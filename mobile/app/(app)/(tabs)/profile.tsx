import { Ionicons } from '@expo/vector-icons';
import { router } from 'expo-router';
import { Alert, Image, Linking, Pressable, ScrollView, StyleSheet, Text, View } from 'react-native';

import { Button } from '../../../components/Button';
import { Screen } from '../../../components/Screen';
import { colors, radius, shadow, spacing, typography } from '../../../constants/theme';
import { useAuthStore } from '../../../stores/authStore';
import { useCartStore } from '../../../stores/cartStore';

export default function ProfileScreen() {
  const user = useAuthStore((s) => s.user);
  const signOut = useAuthStore((s) => s.signOut);
  const resetCart = useCartStore((s) => s.reset);

  const handleLogout = async () => {
    Alert.alert('Sign Out', 'Are you sure you want to sign out of Streetman?', [
      { text: 'Cancel', style: 'cancel' },
      {
        text: 'Sign Out',
        style: 'destructive',
        onPress: async () => {
          await signOut();
          resetCart();
          router.replace('/login');
        },
      },
    ]);
  };

  const handleCall = () => {
    Linking.openURL('tel:0546441987').catch(() => {
      Alert.alert('Streetman Order Line', 'Call or WhatsApp us on: 0546441987');
    });
  };

  const menu: { icon: keyof typeof Ionicons.glyphMap; label: string; onPress: () => void }[] = [
    {
      icon: 'receipt-outline',
      label: 'My Orders',
      onPress: () => router.push('/(app)/(tabs)/orders'),
    },
    {
      icon: 'restaurant-outline',
      label: 'Streetman Menu',
      onPress: () => router.push('/(app)/(tabs)'),
    },
    {
      icon: 'cart-outline',
      label: 'My Food Bag',
      onPress: () => router.push('/(app)/(tabs)/cart'),
    },
    {
      icon: 'call-outline',
      label: 'Order Hotline (0546441987)',
      onPress: handleCall,
    },
    {
      icon: 'logo-instagram',
      label: 'Follow Us (@streetman_foods)',
      onPress: () => Alert.alert('Follow Streetman', 'Find us on Instagram, TikTok & Facebook: @streetman_foods'),
    },
  ];

  return (
    <Screen>
      <ScrollView contentContainerStyle={styles.content}>
        <View style={styles.hero}>
          <View style={styles.avatar}>
            <Image
              source={require('../../../assets/streetman-logo.png')}
              style={styles.avatarLogo}
              resizeMode="cover"
            />
          </View>
          <Text style={styles.name}>{user?.name ?? 'Streetman Foodie'}</Text>
          <Text style={styles.email}>{user?.email ?? '—'}{user?.phone ? `  •  ${user.phone}` : ''}</Text>
          <View style={styles.rolePill}>
            <Ionicons name="flame" color={colors.gold} size={14} />
            <Text style={styles.roleText}>Streetman Member</Text>
          </View>
        </View>

        <View style={styles.brandCard}>
          <Text style={styles.brandCardTitle}>STREETMAN CAFE & FLAMES</Text>
          <Text style={styles.brandCardSubtitle}>AUTHENTIC STREET FOOD</Text>
          <Text style={styles.brandCardTagline}>“Taste the Street, Love the Flavor.”</Text>
          <View style={styles.socialBadges}>
            <View style={styles.socialBadge}><Text style={styles.socialText}>Facebook</Text></View>
            <View style={styles.socialBadge}><Text style={styles.socialText}>Instagram</Text></View>
            <View style={styles.socialBadge}><Text style={styles.socialText}>TikTok</Text></View>
          </View>
        </View>

        <View style={styles.menuCard}>
          {menu.map((item, idx) => (
            <Pressable
              key={item.label}
              onPress={item.onPress}
              style={({ pressed }) => [
                styles.menuRow,
                idx < menu.length - 1 && styles.menuRowBorder,
                pressed && { opacity: 0.7 },
              ]}
            >
              <View style={styles.menuIcon}>
                <Ionicons name={item.icon} color={colors.primary} size={20} />
              </View>
              <Text style={styles.menuLabel}>{item.label}</Text>
              <Ionicons name="chevron-forward" color={colors.textMuted} size={18} />
            </Pressable>
          ))}
        </View>

        <Button title="Sign Out" variant="danger" style={styles.signOut} onPress={handleLogout} />
      </ScrollView>
    </Screen>
  );
}

const styles = StyleSheet.create({
  content: { padding: spacing.md, paddingBottom: spacing.xl },
  hero: {
    backgroundColor: colors.cardDark,
    borderRadius: radius.xl,
    paddingVertical: spacing.lg,
    paddingHorizontal: spacing.md,
    alignItems: 'center',
    overflow: 'hidden',
    marginBottom: spacing.md,
    ...shadow.button,
  },
  avatar: {
    width: 86,
    height: 86,
    borderRadius: radius.full,
    borderWidth: 3,
    borderColor: colors.primary,
    overflow: 'hidden',
    backgroundColor: colors.surface,
  },
  avatarLogo: {
    width: '100%',
    height: '100%',
  },
  name: {
    ...typography.heading,
    fontSize: 20,
    color: colors.white,
    marginTop: spacing.md,
  },
  email: {
    color: 'rgba(255,255,255,0.8)',
    fontSize: 13,
    marginTop: 2,
  },
  rolePill: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 5,
    backgroundColor: 'rgba(185, 28, 28, 0.4)',
    borderRadius: radius.full,
    paddingHorizontal: spacing.md,
    paddingVertical: 5,
    marginTop: spacing.sm + 2,
    borderWidth: 1,
    borderColor: colors.primary,
  },
  roleText: {
    color: colors.white,
    fontSize: 12,
    fontWeight: '800',
  },
  brandCard: {
    backgroundColor: colors.surface,
    borderRadius: radius.lg,
    padding: spacing.md,
    borderWidth: 1,
    borderColor: colors.border,
    alignItems: 'center',
    marginBottom: spacing.md,
    ...shadow.card,
  },
  brandCardTitle: {
    fontSize: 15,
    fontWeight: '900',
    color: colors.primary,
    letterSpacing: 0.5,
  },
  brandCardSubtitle: {
    fontSize: 11,
    fontWeight: '800',
    color: colors.textMuted,
    letterSpacing: 1.2,
    marginTop: 2,
  },
  brandCardTagline: {
    fontSize: 13,
    fontStyle: 'italic',
    color: colors.text,
    marginTop: spacing.xs,
    fontWeight: '600',
  },
  socialBadges: {
    flexDirection: 'row',
    gap: spacing.sm,
    marginTop: spacing.sm + 2,
  },
  socialBadge: {
    backgroundColor: colors.primaryLight,
    paddingHorizontal: spacing.sm + 2,
    paddingVertical: 4,
    borderRadius: radius.full,
  },
  socialText: {
    color: colors.primaryDark,
    fontSize: 11,
    fontWeight: '700',
  },
  menuCard: {
    backgroundColor: colors.surface,
    borderRadius: radius.lg,
    borderWidth: 1,
    borderColor: colors.border,
    paddingHorizontal: spacing.md,
    ...shadow.card,
  },
  menuRow: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: spacing.md,
    gap: spacing.sm + 2,
  },
  menuRowBorder: {
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  menuIcon: {
    width: 38,
    height: 38,
    borderRadius: radius.md,
    backgroundColor: colors.primaryLight,
    alignItems: 'center',
    justifyContent: 'center',
  },
  menuLabel: {
    flex: 1,
    fontSize: 14.5,
    fontWeight: '600',
    color: colors.text,
  },
  signOut: {
    marginTop: spacing.lg,
  },
});