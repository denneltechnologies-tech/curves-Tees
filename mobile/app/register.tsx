import { Ionicons } from '@expo/vector-icons';
import { router } from 'expo-router';
import { useState } from 'react';
import { Image, KeyboardAvoidingView, Platform, ScrollView, StyleSheet, Text, View } from 'react-native';

import { Button } from '../components/Button';
import { Input } from '../components/Input';
import { Screen } from '../components/Screen';
import { colors, radius, shadow, spacing, typography } from '../constants/theme';
import { getErrorMessage } from '../services/api';
import { register } from '../services/auth';
import { useAuthStore } from '../stores/authStore';

export default function RegisterScreen() {
  const signIn = useAuthStore((s) => s.signIn);
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [password, setPassword] = useState('');
  const [passwordConfirmation, setPasswordConfirmation] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  const submit = async () => {
    setError(null);
    if (password !== passwordConfirmation) {
      setError('Passwords do not match.');
      return;
    }
    setLoading(true);
    try {
      const data = await register({ name, email, phone, password, password_confirmation: passwordConfirmation });
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
              JOIN <Text style={styles.brandAccent}>STREETMAN</Text>
            </Text>
            <Text style={styles.tagline}>Good Food. Good Mood. Streetman!</Text>
          </View>

          <View style={styles.card}>
            {error ? (
              <View style={styles.errorBox}>
                <Ionicons name="alert-circle" color={colors.danger} size={18} />
                <Text style={styles.errorText}>{error}</Text>
              </View>
            ) : null}

            <Input label="Full Name" value={name} onChangeText={setName} placeholder="Kwame Mensah" />
            <Input label="Email Address" value={email} onChangeText={setEmail} autoCapitalize="none" keyboardType="email-address" placeholder="you@example.com" />
            <Input label="Phone Number (e.g. 0546441987)" value={phone} onChangeText={setPhone} keyboardType="phone-pad" placeholder="0546441987" />
            <Input label="Password" value={password} onChangeText={setPassword} secureTextEntry placeholder="••••••••" />
            <Input label="Confirm Password" value={passwordConfirmation} onChangeText={setPasswordConfirmation} secureTextEntry placeholder="••••••••" />

            <Button title="Create Account" onPress={submit} loading={loading} />

            <View style={styles.dividerRow}>
              <View style={styles.divider} />
              <Text style={styles.dividerText}>ALREADY HAVE AN ACCOUNT?</Text>
              <View style={styles.divider} />
            </View>

            <Button title="Sign In" variant="ghost" onPress={() => router.replace('/login')} />
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
    width: 80,
    height: 80,
    borderRadius: radius.full,
    marginBottom: spacing.xs,
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
  tagline: {
    ...typography.caption,
    textAlign: 'center',
    color: colors.textMuted,
    marginTop: 2,
    fontWeight: '600',
  },
  card: {
    backgroundColor: colors.surface,
    borderRadius: radius.xl,
    padding: spacing.lg,
    borderWidth: 1,
    borderColor: colors.border,
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