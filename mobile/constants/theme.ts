export const colors = {
  primary: '#B91C1C', // Flame Red
  primaryDark: '#991B1B', // Deep Burgundy Red
  primaryDeep: '#7F1D1D',
  primaryLight: '#FEE2E2', // Soft Crimson Tint
  accent: '#F59E0B', // Streetman Gold / Amber
  accentDark: '#D97706',
  accentLight: '#FEF3C7',
  tint: '#FFF7ED',
  background: '#F8F9FA',
  surface: '#FFFFFF',
  cardDark: '#111827', // Rich charcoal card background
  cardDarkBorder: '#1F2937',
  text: '#0F172A',
  textMuted: '#64748B',
  textLight: '#FFFFFF',
  border: '#E2E8F0',
  danger: '#DC2626',
  success: '#16A34A',
  info: '#2563EB',
  white: '#FFFFFF',
  dark: '#0F172A',
  flame: '#EA580C',
  gold: '#FBBF24',
  overlay: 'rgba(15, 23, 42, 0.05)',
};

export const spacing = {
  xs: 4,
  sm: 8,
  md: 16,
  lg: 24,
  xl: 32,
};

export const radius = {
  sm: 8,
  md: 10,
  lg: 16,
  xl: 22,
  full: 9999,
};

export const shadow = {
  card: {
    shadowColor: '#0f172a',
    shadowOpacity: 0.08,
    shadowRadius: 12,
    shadowOffset: { width: 0, height: 4 },
    elevation: 3,
  },
  button: {
    shadowColor: '#991b1b',
    shadowOpacity: 0.35,
    shadowRadius: 10,
    shadowOffset: { width: 0, height: 4 },
    elevation: 4,
  },
  accentButton: {
    shadowColor: '#d97706',
    shadowOpacity: 0.35,
    shadowRadius: 10,
    shadowOffset: { width: 0, height: 4 },
    elevation: 4,
  },
};

export const typography = {
  title: { fontSize: 26, fontWeight: '800' as const, color: colors.text, letterSpacing: -0.5 },
  heading: { fontSize: 20, fontWeight: '700' as const, color: colors.text, letterSpacing: -0.3 },
  section: { fontSize: 16, fontWeight: '700' as const, color: colors.text },
  body: { fontSize: 15, color: colors.text },
  caption: { fontSize: 13, color: colors.textMuted },
};