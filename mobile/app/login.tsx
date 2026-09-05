import { Ionicons } from '@expo/vector-icons';
import { router } from 'expo-router';
import { useState } from 'react';
import { Image, KeyboardAvoidingView, Platform, ScrollView, StyleSheet, Text, View } from 'react-native';

import { Button } from '../components/Button';
import { Input } from '../components/Input';
import { Screen } from '../components/Screen';
import { colors, radius, shadow, spacing, typography } from '../constants/theme';
import { login } from '../services/auth';
import { getErrorMessage } from '../services/api';
import { useAuthStore } from '../stores/authStore';

export default function LoginScreen() {
  const signIn = useAuthStore((s) => s.signIn);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  const submit = async () => {
    setError(null);
    setLoading(true);
    try {
      const data = await login({ email, password });
      await signIn(data.token, data.user);
      router.replace('/(app)/(tabs)');
    } catch (err) {
      setError(getErrorMessage(err));
    } finally {
      setLoading(false);
    }
  };

  return (
    <Screen safeEdges={['top', 'bottom']}>
      <KeyboardAvoidingView
        style={styles.flex}
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      >
        <View style={styles.decorTop} />
        <View style={styles.decorBottom} />
        <ScrollView contentContainerStyle={styles.content} keyboardShouldPersistTaps="handled">
          <View style={styles.brandContainer}>
            <Image
              source={require('../assets/streetman-logo.png')}
              style={styles.logoImage}
              resizeMode="contain"
            />
            <Text style={styles.brandTitle}>
              STREETMAN <Text style={styles.brandAccent}>CAFE & FLAMES</Text>
            </Text>
            <View style={styles.badgeRow}>
              <View style={styles.badge}>
                <Text style={styles.badgeText}>AUTHENTIC STREET FOOD</Text>
              </View>
            </View>
            <Text style={styles.tagline}>Taste the Street, Love the Flavor.</Text>
          </View>

          <View style={styles.card}>
            {error ? (
              <View style={styles.errorBox}>
                <Ionicons name="alert-circle" color={colors.danger} size={18} />
                <Text style={styles.errorText}>{error}</Text>
              </View>
            ) : null}

            <Input
              label="Email Address"
              value={email}
              onChangeText={setEmail}
              autoCapitalize="none"
              keyboardType="email-address"
              placeholder="you@example.com"
            />
            <Input
              label="Password"
              value={password}
              onChangeText={setPassword}
              secureTextEntry
              placeholder="••••••••"
            />

            <Button title="Sign In" onPress={submit} loading={loading} style={styles.signInBtn} />

            <View style={styles.dividerRow}>
              <View style={styles.divider} />
              <Text style={styles.dividerText}>NEW TO STREETMAN?</Text>
              <View style={styles.divider} />
            </View>

            <Button title="Create an Account" variant="ghost" onPress={() => router.push('/register')} />
          </View>
        </ScrollView>
      </KeyboardAvoidingView>
    </Screen>
  );
}

const styles = StyleSheet.create({
  flex: { flex: 1 },
  decorTop: {
    position: 'absolute',
    top: -90,
    right: -90,
    width: 240,
    height: 240,
    borderRadius: 120,
    backgroundColor: colors.primaryLight,
  },
  decorBottom: {
    position: 'absolute',
    bottom: -70,
    left: -70,
    width: 180,
    height: 180,
    borderRadius: 90,
    backgroundColor: colors.tint,
  },
  content: {
    flexGrow: 1,
    justifyContent: 'center',
    padding: spacing.lg,
  },
  brandContainer: {
    alignItems: 'center',
    marginBottom: spacing.lg,
  },
  logoImage: {
    width: 96,
    height: 96,
    borderRadius: radius.full,
    marginBottom: spacing.sm,
    ...shadow.button,
  },
  brandTitle: {
    ...typography.title,
    fontSize: 22,
    letterSpacing: -0.5,
    textAlign: 'center',
  },
  brandAccent: {
    color: colors.primary,
  },
  badgeRow: {
    marginTop: 4,
    marginBottom: 4,
  },
  badge: {
    backgroundColor: colors.primary,
    paddingHorizontal: spacing.sm + 4,
    paddingVertical: 3,
    borderRadius: radius.full,
  },
  badgeText: {
    color: colors.white,
    fontSize: 10.5,
    fontWeight: '800',
    letterSpacing: 1.2,
  },
  tagline: {
    ...typography.caption,
    textAlign: 'center',
    fontStyle: 'italic',
    color: colors.textMuted,
    marginTop: 4,
  },
  card: {
    backgroundColor: colors.surface,
    borderRadius: radius.xl,
    padding: spacing.lg,
    borderWidth: 1,
    borderColor: colors.border,
    ...shadow.card,
  },
  signInBtn: {
    marginTop: spacing.xs,
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
    marginBottom: spacing.md,
  },
  errorText: {
    color: colors.danger,
    fontSize: 13,
    fontWeight: '500',
    flex: 1,
  },
  dividerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
    marginVertical: spacing.md,
  },
  divider: {
    flex: 1,
    height: 1,
    backgroundColor: colors.border,
  },
  dividerText: {
    color: colors.textMuted,
    fontSize: 11,
    fontWeight: '700',
    letterSpacing: 0.5,
  },
});