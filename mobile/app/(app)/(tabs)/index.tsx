import { Ionicons } from '@expo/vector-icons';
import { router } from 'expo-router';
import { useCallback, useEffect, useRef, useState } from 'react';
import {
  ActivityIndicator,
  FlatList,
  Image,
  Pressable,
  RefreshControl,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  View,
} from 'react-native';

import { ProductCard } from '../../../components/ProductCard';
import { Screen } from '../../../components/Screen';
import { colors, radius, shadow, spacing, typography } from '../../../constants/theme';
import { ApiError } from '../../../services/api';
import { fetchCategories, fetchProducts } from '../../../services/products';
import { useAuthStore } from '../../../stores/authStore';
import type { Category, Product } from '../../../types';

export default function HomeScreen() {
  const user = useAuthStore((s) => s.user);
  const [categories, setCategories] = useState<Category[]>([]);
  const [products, setProducts] = useState<Product[]>([]);
  const [selectedCategory, setSelectedCategory] = useState<number | null>(null);
  const [search, setSearch] = useState('');
  const [page, setPage] = useState(1);
  const [hasMore, setHasMore] = useState(true);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);
  const [loadingMore, setLoadingMore] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const debounceRef = useRef<ReturnType<typeof setTimeout> | null>(null);

  const loadProducts = useCallback(async (reset = false, cat: number | null = selectedCategory, q = search) => {
    try {
      if (reset) setLoading(true);
      const targetPage = reset ? 1 : page;
      const res = await fetchProducts({
        page: targetPage,
        category_id: cat ?? undefined,
        search: q || undefined,
      });
      setProducts((prev) => (reset ? res.items : [...prev, ...res.items]));
      setPage(res.pagination.current_page + 1);
      setHasMore(res.pagination.current_page < res.pagination.last_page);
      setError(null);
    } catch (err) {
      setError(err instanceof ApiError ? err.message : 'Failed to load products.');
    } finally {
      setLoading(false);
      setRefreshing(false);
      setLoadingMore(false);
    }
  }, [page, search, selectedCategory]);

  const loadCategories = useCallback(async () => {
    try {
      const res = await fetchCategories();
      setCategories(res);
    } catch {
      // non-fatal
    }
  }, []);

  const refresh = useCallback(() => {
    setRefreshing(true);
    setPage(1);
    loadCategories();
    loadProducts(true);
  }, [loadProducts, loadCategories]);

  useEffect(() => {
    loadCategories();
    loadProducts(true);
  }, [loadProducts, loadCategories]);

  useEffect(() => {
    if (debounceRef.current) clearTimeout(debounceRef.current);
    debounceRef.current = setTimeout(() => {
      setPage(1);
      loadProducts(true);
    }, 400);
    return () => {
      if (debounceRef.current) clearTimeout(debounceRef.current);
    };
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [search, selectedCategory]);

  const onEndReached = () => {
    if (hasMore && !loadingMore && !loading) {
      setLoadingMore(true);
      loadProducts(false);
    }
  };

  const firstName = (user?.name ?? 'Foodie').split(' ')[0];

  return (
    <Screen>
      <View style={styles.header}>
        <View style={styles.greetingRow}>
          <Image
            source={require('../../../assets/streetman-logo.png')}
            style={styles.headerLogo}
            resizeMode="cover"
          />
          <View style={styles.greetingTexts}>
            <Text style={styles.greeting}>Hey, {firstName} 👋</Text>
            <Text style={styles.greetingSub}>Taste the Street, Love the Flavor.</Text>
          </View>
          <Pressable style={styles.notifBtn} onPress={() => router.push('/(app)/(tabs)/profile')}>
            <Ionicons name="notifications-outline" color={colors.text} size={20} />
          </Pressable>
        </View>
        <View style={styles.searchWrap}>
          <Ionicons name="search" color={colors.textMuted} size={18} />
          <TextInput
            style={styles.search}
            placeholder="Search fried rice, jollof, boba..."
            value={search}
            onChangeText={setSearch}
            placeholderTextColor={colors.textMuted}
          />
          {search ? (
            <Pressable onPress={() => setSearch('')}>
              <Ionicons name="close-circle" color={colors.textMuted} size={18} />
            </Pressable>
          ) : null}
        </View>
      </View>

      <FlatList
        data={products}
        keyExtractor={(item) => String(item.id)}
        numColumns={2}
        columnWrapperStyle={styles.row}
        contentContainerStyle={styles.listContent}
        keyboardShouldPersistTaps="handled"
        refreshControl={<RefreshControl refreshing={refreshing} onRefresh={refresh} tintColor={colors.primary} />}
        onEndReached={onEndReached}
        onEndReachedThreshold={0.3}
        ListHeaderComponent={
          <>
            <View style={styles.hero}>
              <Image
                source={require('../../../assets/streetman-hero.png')}
                style={styles.heroBackground}
                resizeMode="cover"
              />
              <View style={styles.heroOverlay} />
              <View style={styles.heroContent}>
                <View style={styles.heroBadge}>
                  <Ionicons name="flame" color={colors.accent} size={13} />
                  <Text style={styles.heroEyebrow}>AUTHENTIC STREET FOOD</Text>
                </View>
                <Text style={styles.heroTitle}>Streetman Style{'\n'}<Text style={styles.heroAccent}>Milk & Fries Combo</Text></Text>
                <Text style={styles.heroSub}>Crispy golden fries + crispy chicken + sausages + creamy milkshake!</Text>
                
                <View style={styles.taglineRow}>
                  <Text style={styles.taglineBadge}>GOOD FOOD • GOOD MOOD</Text>
                </View>
              </View>
            </View>

            <View style={styles.featureBar}>
              <View style={styles.featureItem}>
                <Ionicons name="flame-outline" color={colors.primary} size={16} />
                <Text style={styles.featureText}>Freshly Prepared</Text>
              </View>
              <View style={styles.featureDivider} />
              <View style={styles.featureItem}>
                <Ionicons name="restaurant-outline" color={colors.accent} size={16} />
                <Text style={styles.featureText}>Quality Taste</Text>
              </View>
              <View style={styles.featureDivider} />
              <View style={styles.featureItem}>
                <Ionicons name="bicycle-outline" color={colors.success} size={16} />
                <Text style={styles.featureText}>Fast Delivery</Text>
              </View>
            </View>

            <View style={styles.sectionHeader}>
              <Text style={styles.sectionTitle}>Our Menu</Text>
              <Text style={styles.sectionSub}>Authentic Street Meals</Text>
            </View>

            <ScrollView horizontal showsHorizontalScrollIndicator={false} contentContainerStyle={styles.chips}>
              <Pressable
                style={[styles.chip, selectedCategory === null && styles.chipActive]}
                onPress={() => setSelectedCategory(null)}
              >
                <Ionicons
                  name="restaurant"
                  size={15}
                  color={selectedCategory === null ? colors.white : colors.primary}
                />
                <Text style={[styles.chipText, selectedCategory === null && styles.chipTextActive]}>All Menu</Text>
              </Pressable>
              {categories.map((c) => (
                <Pressable
                  key={c.id}
                  style={[styles.chip, selectedCategory === c.id && styles.chipActive]}
                  onPress={() => setSelectedCategory(c.id)}
                >
                  <Text style={[styles.chipText, selectedCategory === c.id && styles.chipTextActive]}>{c.name}</Text>
                </Pressable>
              ))}
            </ScrollView>
            {error ? <Text style={styles.error}>{error}</Text> : null}
          </>
        }
        ListEmptyComponent={
          loading ? (
            <View style={styles.center}><ActivityIndicator color={colors.primary} size="large" /></View>
          ) : (
            <View style={styles.center}><Text style={styles.empty}>No food items found.</Text></View>
          )
        }
        ListFooterComponent={
          loadingMore ? <ActivityIndicator color={colors.primary} style={styles.footerLoader} /> : null
        }
        renderItem={({ item }) => (
          <ProductCard product={item} onPress={(p) => router.push(`/(app)/product/${p.id}`)} />
        )}
      />
    </Screen>
  );
}

const styles = StyleSheet.create({
  header: {
    paddingHorizontal: spacing.md,
    paddingTop: spacing.sm,
    paddingBottom: spacing.sm,
  },
  greetingRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.md,
  },
  headerLogo: {
    width: 44,
    height: 44,
    borderRadius: radius.full,
    borderWidth: 2,
    borderColor: colors.primary,
  },
  greetingTexts: {
    flex: 1,
    marginLeft: spacing.sm + 2,
  },
  greeting: {
    ...typography.heading,
    fontSize: 18,
    color: colors.text,
  },
  greetingSub: {
    ...typography.caption,
    fontSize: 12.5,
    marginTop: 1,
    color: colors.primaryDark,
    fontWeight: '600',
  },
  notifBtn: {
    width: 40,
    height: 40,
    borderRadius: radius.full,
    backgroundColor: colors.surface,
    borderWidth: 1,
    borderColor: colors.border,
    alignItems: 'center',
    justifyContent: 'center',
  },
  searchWrap: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.sm,
    backgroundColor: colors.surface,
    borderWidth: 1,
    borderColor: colors.border,
    borderRadius: radius.full,
    paddingHorizontal: spacing.md,
    height: 46,
    ...shadow.card,
  },
  search: {
    flex: 1,
    fontSize: 14.5,
    color: colors.text,
    height: '100%',
  },
  listContent: {
    paddingHorizontal: spacing.md,
    paddingBottom: spacing.xl,
  },
  row: {
    justifyContent: 'space-between',
    gap: spacing.sm + 2,
  },
  hero: {
    borderRadius: radius.xl,
    marginTop: spacing.sm,
    marginBottom: spacing.sm,
    overflow: 'hidden',
    height: 190,
    position: 'relative',
    ...shadow.button,
  },
  heroBackground: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    width: '100%',
    height: '100%',
  },
  heroOverlay: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    backgroundColor: 'rgba(15, 17, 23, 0.72)',
  },
  heroContent: {
    padding: spacing.md + 2,
    flex: 1,
    justifyContent: 'space-between',
  },
  heroBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
    alignSelf: 'flex-start',
    backgroundColor: 'rgba(185, 28, 28, 0.85)',
    paddingHorizontal: spacing.sm + 2,
    paddingVertical: 3,
    borderRadius: radius.full,
  },
  heroEyebrow: {
    color: colors.white,
    fontSize: 10,
    fontWeight: '900',
    letterSpacing: 1.5,
  },
  heroTitle: {
    color: colors.white,
    fontSize: 22,
    fontWeight: '900',
    letterSpacing: -0.5,
    lineHeight: 26,
  },
  heroAccent: {
    color: colors.gold,
  },
  heroSub: {
    color: 'rgba(255,255,255,0.9)',
    fontSize: 12,
    lineHeight: 16,
    maxWidth: 260,
  },
  taglineRow: {
    flexDirection: 'row',
  },
  taglineBadge: {
    backgroundColor: 'rgba(245, 158, 11, 0.9)',
    color: colors.dark,
    fontSize: 9.5,
    fontWeight: '900',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: radius.sm,
    letterSpacing: 0.8,
  },
  featureBar: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-around',
    backgroundColor: colors.surface,
    borderRadius: radius.lg,
    paddingVertical: spacing.sm + 2,
    paddingHorizontal: spacing.sm,
    borderWidth: 1,
    borderColor: colors.border,
    marginBottom: spacing.md,
    ...shadow.card,
  },
  featureItem: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 5,
  },
  featureText: {
    fontSize: 11.5,
    fontWeight: '700',
    color: colors.text,
  },
  featureDivider: {
    width: 1,
    height: 16,
    backgroundColor: colors.border,
  },
  sectionHeader: {
    marginBottom: spacing.xs,
  },
  sectionTitle: {
    fontSize: 18,
    fontWeight: '800',
    color: colors.text,
    letterSpacing: -0.3,
  },
  sectionSub: {
    fontSize: 12,
    color: colors.textMuted,
    marginTop: 1,
  },
  chips: {
    paddingVertical: spacing.sm,
    gap: spacing.sm,
  },
  chip: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm + 1,
    borderRadius: radius.full,
    borderWidth: 1,
    borderColor: colors.border,
    backgroundColor: colors.surface,
  },
  chipActive: {
    backgroundColor: colors.primary,
    borderColor: colors.primary,
  },
  chipText: {
    color: colors.text,
    fontWeight: '700',
    fontSize: 13,
  },
  chipTextActive: {
    color: colors.white,
  },
  error: {
    color: colors.danger,
    textAlign: 'center',
    marginTop: spacing.sm,
  },
  center: {
    padding: spacing.xl,
    alignItems: 'center',
  },
  empty: {
    color: colors.textMuted,
    fontSize: 15,
  },
  footerLoader: {
    padding: spacing.md,
  },
});