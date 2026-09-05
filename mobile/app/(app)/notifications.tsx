import { Ionicons } from '@expo/vector-icons';
import { useFocusEffect } from 'expo-router';
import { useCallback, useState } from 'react';
import { ActivityIndicator, FlatList, Pressable, StyleSheet, Text, View } from 'react-native';

import { EmptyState } from '../../components/EmptyState';
import { Screen } from '../../components/Screen';
import { colors, radius, shadow, spacing, typography } from '../../constants/theme';
import { ApiError } from '../../services/api';
import { fetchNotifications, markAllNotificationsRead, markNotificationRead } from '../../services/notifications';
import type { AppNotification } from '../../types';

export default function NotificationsScreen() {
  const [notifications, setNotifications] = useState<AppNotification[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const load = useCallback(async () => {
    try {
      const res = await fetchNotifications();
      setNotifications(res);
      setError(null);
    } catch (err) {
      setError(err instanceof ApiError ? err.message : 'Failed to load notifications.');
    } finally {
      setLoading(false);
    }
  }, []);

  useFocusEffect(
    useCallback(() => {
      load();
    }, [load]),
  );

  const handleMarkRead = async (notification: AppNotification) => {
    if (notification.read_at) return;
    setNotifications((prev) =>
      prev.map((n) => (n.id === notification.id ? { ...n, read_at: new Date().toISOString() } : n)),
    );
    try {
      await markNotificationRead(notification.id);
    } catch {
      load();
    }
  };

  const handleMarkAllRead = async () => {
    if (notifications.length === 0) return;
    setNotifications((prev) => prev.map((n) => ({ ...n, read_at: n.read_at ?? new Date().toISOString() })));
    try {
      await markAllNotificationsRead();
    } catch {
      load();
    }
  };

  const unreadCount = notifications.filter((n) => !n.read_at).length;

  return (
    <Screen safeEdges={[]}>
      {loading ? (
        <View style={styles.center}><ActivityIndicator color={colors.primary} size="large" /></View>
      ) : error ? (
        <EmptyState title="Something went wrong" message={error} icon="alert-circle-outline" />
      ) : notifications.length === 0 ? (
        <EmptyState
          title="No notifications yet"
          message="Order updates, promotions and Streetman announcements will appear here."
          icon="notifications-off-outline"
        />
      ) : (
        <FlatList
          data={notifications}
          keyExtractor={(item) => String(item.id)}
          contentContainerStyle={styles.listContent}
          ListHeaderComponent={
            unreadCount > 0 ? (
              <View style={styles.unreadBar}>
                <Text style={styles.unreadText}>{unreadCount} unread</Text>
                <Pressable onPress={handleMarkAllRead} hitSlop={8}>
                  <Text style={styles.markAll}>Mark all read</Text>
                </Pressable>
              </View>
            ) : null
          }
          renderItem={({ item }) => (
            <Pressable
              style={({ pressed }) => [styles.card, !item.read_at && styles.cardUnread, pressed && styles.pressed]}
              onPress={() => handleMarkRead(item)}
            >
              <View style={styles.iconWrap}>
                <Ionicons name={iconFor(item.type)} color={colors.primary} size={20} />
              </View>
              <View style={styles.body}>
                <Text style={[styles.title, !item.read_at && styles.titleUnread]}>{item.title}</Text>
                {item.body ? <Text style={styles.message}>{item.body}</Text> : null}
                <Text style={styles.time}>{formatTime(item.created_at)}</Text>
              </View>
              {!item.read_at ? <View style={styles.dot} /> : null}
            </Pressable>
          )}
        />
      )}
    </Screen>
  );
}

function iconFor(type: string): keyof typeof Ionicons.glyphMap {
  switch (type) {
    case 'order':
    case 'order_status':
      return 'restaurant-outline';
    case 'payment':
      return 'card-outline';
    case 'promo':
      return 'pricetag-outline';
    default:
      return 'notifications-outline';
  }
}

function formatTime(value: string): string {
  const d = new Date(value);
  if (Number.isNaN(d.getTime())) return '';
  return d.toLocaleString(undefined, {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
}

const styles = StyleSheet.create({
  center: { flex: 1, alignItems: 'center', justifyContent: 'center' },
  listContent: { padding: spacing.md, paddingBottom: spacing.xl },
  unreadBar: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: spacing.sm,
    paddingHorizontal: 2,
  },
  unreadText: { color: colors.textMuted, fontSize: 13, fontWeight: '600' },
  markAll: { color: colors.primary, fontSize: 13, fontWeight: '700' },
  card: {
    flexDirection: 'row',
    alignItems: 'flex-start',
    gap: spacing.sm + 2,
    backgroundColor: colors.surface,
    borderRadius: radius.lg,
    borderWidth: 1,
    borderColor: colors.border,
    padding: spacing.md,
    marginBottom: spacing.sm + 2,
    ...shadow.card,
  },
  cardUnread: {
    borderColor: colors.primary,
    backgroundColor: colors.primaryLight,
  },
  pressed: { opacity: 0.9 },
  iconWrap: {
    width: 40,
    height: 40,
    borderRadius: radius.md,
    backgroundColor: colors.surface,
    borderWidth: 1,
    borderColor: colors.border,
    alignItems: 'center',
    justifyContent: 'center',
  },
  body: { flex: 1 },
  title: { ...typography.section, fontWeight: '600', fontSize: 15, color: colors.text },
  titleUnread: { fontWeight: '800', color: colors.text },
  message: { color: colors.textMuted, fontSize: 13.5, marginTop: 2, lineHeight: 19 },
  time: { color: colors.textMuted, fontSize: 11.5, marginTop: spacing.sm },
  dot: {
    width: 9,
    height: 9,
    borderRadius: radius.full,
    backgroundColor: colors.primary,
    marginTop: 6,
  },
});