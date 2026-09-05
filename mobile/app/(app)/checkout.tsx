import { Ionicons } from '@expo/vector-icons';
import { router } from 'expo-router';
import * as WebBrowser from 'expo-web-browser';
import { useMemo, useState } from 'react';
import { ActivityIndicator, Alert, KeyboardAvoidingView, Platform, ScrollView, StyleSheet, Text, View } from 'react-native';

import { Button } from '../../components/Button';
import { Input } from '../../components/Input';
import { Screen } from '../../components/Screen';
import { colors, radius, shadow, spacing, typography } from '../../constants/theme';
import { ApiError } from '../../services/api';
import { fetchCart } from '../../services/cart';
import { checkout } from '../../services/orders';
import { initializePayment, verifyPayment } from '../../services/payment';
import { useCartStore } from '../../stores/cartStore';
import type { Cart } from '../../types';

export default function CheckoutScreen() {
  const setCart = useCartStore((s) => s.setCart);
  const [cart, setLocalCart] = useState<Cart | null>(null);
  const [recipientName, setRecipientName] = useState('');
  const [phone, setPhone] = useState('');
  const [address, setAddress] = useState('');
  const [city, setCity] = useState('');
  const [notes, setNotes] = useState('');
  const [loading, setLoading] = useState(true);
  const [submitting, setSubmitting] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const subtotal = cart?.subtotal ?? 0;
  const deliveryFee = 0;
  const total = subtotal + deliveryFee;

  useMemo(() => {
    let active = true;
    (async () => {
      try {
        const res = await fetchCart();
        if (active) {
          setLocalCart(res);
          setCart(res);
        }
      } catch (err) {
        if (active) setError(err instanceof ApiError ? err.message : 'Failed to load order cart.');
      } finally {
        if (active) setLoading(false);
      }
    })();
    return () => {
      active = false;
    };
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  const placeOrder = async () => {
    if (!recipientName || !phone || !address) {
      setError('Please provide recipient name, phone number, and delivery address.');
      return;
    }
    setError(null);
    setSubmitting(true);
    try {
      const order = await checkout({
        delivery_information: {
          recipient_name: recipientName,
          phone,
          address,
          city: city || undefined,
          additional_notes: notes || undefined,
        },
      });
      await handlePayment(order.id);
    } catch (err) {
      setError(err instanceof ApiError ? err.message : 'Failed to place order.');
      setSubmitting(false);
    }
  };

  const handlePayment = async (orderId: number) => {
    try {
      const init = await initializePayment(orderId, 'paystack');

      if (!init.authorization_url) {
        Alert.alert('Order Placed', 'Your Streetman order was placed successfully.');
        setSubmitting(false);
        router.replace(`/(app)/order/${orderId}`);
        return;
      }

      const result = await WebBrowser.openAuthSessionAsync(init.authorization_url, 'streetman-cafe://paystack');
      if (result.type === 'success') {
        await verifyPayment(init.reference);
        Alert.alert('Payment Received', 'Thank you! Your payment was successful.');
        setSubmitting(false);
        router.replace(`/(app)/order/${orderId}`);
      } else {
        Alert.alert('Order Received', 'Your order is recorded. You can complete payment at any time.');
        setSubmitting(false);
        router.replace(`/(app)/order/${orderId}`);
      }
    } catch (err) {
      setError(err instanceof ApiError ? err.message : 'Payment could not be processed.');
      setSubmitting(false);
    }
  };

  if (loading) {
    return (
      <Screen style={styles.center}>
        <ActivityIndicator color={colors.primary} size="large" />
      </Screen>
    );
  }

  return (
    <Screen safeEdges={[]}>
      <KeyboardAvoidingView
        style={styles.flex}
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      >
        <ScrollView contentContainerStyle={styles.content} keyboardShouldPersistTaps="handled">
          <View style={styles.sectionHead}>
            <View style={styles.sectionIcon}>
              <Ionicons name="location-outline" color={colors.primary} size={20} />
            </View>
            <Text style={styles.sectionTitle}>Delivery Details</Text>
          </View>
          <View style={styles.card}>
            <Input label="Recipient Name" value={recipientName} onChangeText={setRecipientName} placeholder="Kwame Mensah" />
            <Input label="Phone Number" value={phone} onChangeText={setPhone} keyboardType="phone-pad" placeholder="0546441987" />
            <Input label="Delivery Address / Landmark" value={address} onChangeText={setAddress} placeholder="Street, landmark, house number" />
            <Input label="City / Area" value={city} onChangeText={setCity} placeholder="Accra" />
            <Input label="Order Notes (e.g. extra shito, spice level)" value={notes} onChangeText={setNotes} multiline />
          </View>

          {error ? (
            <View style={styles.errorBox}>
              <Ionicons name="alert-circle" color={colors.danger} size={18} />
              <Text style={styles.errorText}>{error}</Text>
            </View>
          ) : null}

          <View style={styles.sectionHead}>
            <View style={styles.sectionIcon}>
              <Ionicons name="receipt-outline" color={colors.primary} size={20} />
            </View>
            <Text style={styles.sectionTitle}>Order Summary</Text>
          </View>
          <View style={styles.card}>
            <View style={styles.summaryRow}>
              <Text style={styles.summaryLabel}>Subtotal</Text>
              <Text style={styles.summaryValue}>GH₵{subtotal.toFixed(0)}</Text>
            </View>
            <View style={styles.summaryRow}>
              <Text style={styles.summaryLabel}>Delivery</Text>
              <Text style={styles.summaryValue}>GH₵{deliveryFee.toFixed(0)}</Text>
            </View>
            <View style={[styles.summaryRow, styles.totalRow]}>
              <Text style={styles.totalLabel}>Total</Text>
              <Text style={styles.totalValue}>GH₵{total.toFixed(0)}</Text>
            </View>
          </View>
        </ScrollView>

        <View style={styles.footer}>
          <Button title="Confirm Order & Pay" onPress={placeOrder} loading={submitting} />
        </View>
      </KeyboardAvoidingView>
    </Screen>
  );
}

const styles = StyleSheet.create({
  flex: { flex: 1 },
  center: { flex: 1, alignItems: 'center', justifyContent: 'center' },
  content: { padding: spacing.md, paddingBottom: spacing.xl },
  sectionHead: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
    marginBottom: spacing.sm,
    marginTop: spacing.sm,
  },
  sectionIcon: {
    width: 34,
    height: 34,
    borderRadius: radius.full,
    backgroundColor: colors.primaryLight,
    alignItems: 'center',
    justifyContent: 'center',
  },
  sectionTitle: {
    ...typography.heading,
    fontSize: 17,
  },
  card: {
    backgroundColor: colors.surface,
    borderRadius: radius.lg,
    borderWidth: 1,
    borderColor: colors.border,
    padding: spacing.md,
    ...shadow.card,
  },
  errorBox: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
    backgroundColor: '#fef2f2',
    borderWidth: 1,
    borderColor: '#fecaca',
    borderRadius: radius.md,
    padding: spacing.sm + 2,
    marginTop: spacing.md,
  },
  errorText: {
    color: colors.danger,
    fontSize: 13,
    fontWeight: '500',
    flex: 1,
  },
  summaryRow: { flexDirection: 'row', justifyContent: 'space-between', marginBottom: spacing.sm },
  totalRow: {
    borderTopWidth: 1,
    borderTopColor: colors.border,
    paddingTop: spacing.sm + 2,
    marginTop: spacing.sm,
    marginBottom: 0,
  },
  summaryLabel: { color: colors.textMuted, fontSize: 15 },
  summaryValue: { color: colors.text, fontWeight: '700', fontSize: 15 },
  totalLabel: { color: colors.text, fontSize: 16, fontWeight: '800' },
  totalValue: { color: colors.primary, fontSize: 18, fontWeight: '900' },
  footer: {
    backgroundColor: colors.surface,
    borderTopWidth: 1,
    borderTopColor: colors.border,
    padding: spacing.md,
    paddingBottom: spacing.lg,
  },
});