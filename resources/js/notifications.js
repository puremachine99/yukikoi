import axios from "axios";

const csrfMeta = document.querySelector('meta[name="csrf-token"]');
const csrfToken = csrfMeta ? csrfMeta.content : null;
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

const severityStyles = {
    info: 'bg-blue-100 text-blue-500',
    warning: 'bg-amber-100 text-amber-600',
    success: 'bg-emerald-100 text-emerald-600',
    primary: 'bg-indigo-100 text-indigo-600',
    danger: 'bg-red-100 text-red-600',
};

const createNotificationItem = (item) => {
    const wrapper = document.createElement('a');
    wrapper.href = item.action_url || '#';
    wrapper.className = 'flex p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors';

    const iconHolder = document.createElement('div');
    const severityClass = severityStyles[item.severity] || severityStyles.info;
    iconHolder.className = `flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center ${severityClass}`;

    const icon = document.createElement('i');
    icon.className = `fa-solid ${item.icon || 'fa-bell'}`;
    iconHolder.appendChild(icon);

    const body = document.createElement('div');
    body.className = 'ml-3 text-sm';

    const title = document.createElement('p');
    title.className = 'font-medium text-gray-900 dark:text-white';
    title.textContent = item.title;
    body.appendChild(title);

    if (item.message) {
        const message = document.createElement('p');
        message.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        message.textContent = item.message;
        body.appendChild(message);
    }

    const time = document.createElement('p');
    time.className = 'text-xs text-gray-400 mt-1';
    time.textContent = item.time_ago || 'Baru saja';
    body.appendChild(time);

    wrapper.appendChild(iconHolder);
    wrapper.appendChild(body);

    return wrapper;
};

const updateBadge = (badge, count) => {
    if (!badge) return;

    if (count > 0) {
        badge.textContent = count > 9 ? '9+' : count;
        badge.classList.remove('hidden');
    } else {
        badge.textContent = '';
        badge.classList.add('hidden');
    }
};

const renderNotifications = (list, emptyState, items) => {
    if (!list) return;

    list.innerHTML = '';

    if (!items || items.length === 0) {
        if (emptyState) {
            emptyState.classList.remove('hidden');
            emptyState.classList.add('block');
        }
        return;
    }

    if (emptyState) {
        emptyState.classList.add('hidden');
    }

    items.forEach((item) => {
        list.appendChild(createNotificationItem(item));
    });
};

const setupRealtime = (userId, onNotification) => {
    if (!window.Echo || !userId) return;

    window.Echo.private(`user.${userId}`).notification((notification) => {
        onNotification({
            id: notification.id,
            title: notification.data?.title ?? 'Notifikasi',
            message: notification.data?.message ?? null,
            icon: notification.data?.icon ?? 'fa-bell',
            severity: notification.data?.severity ?? 'info',
            action_url: notification.data?.action_url ?? '#',
            time_ago: 'Baru saja',
        });
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const userMeta = document.querySelector('meta[name="user-id"]');
    const userId = userMeta ? userMeta.content : null;
    if (!userId) {
        return;
    }

    const toggle = document.querySelector('[data-notification-toggle]');
    const badge = document.querySelector('[data-notification-count]');
    const dropdown = document.querySelector('[data-notification-dropdown]');
    const list = dropdown ? dropdown.querySelector('[data-notification-list]') : null;
    const emptyState = dropdown ? dropdown.querySelector('[data-notification-empty]') : null;
    const markReadButton = dropdown ? dropdown.querySelector('[data-notification-mark-read]') : null;

    if (!toggle || !list) {
        return;
    }

    let hasLoaded = false;
    let unreadCount = 0;

    const fetchNotifications = async () => {
        try {
            const { data } = await axios.get('/notifications');
            renderNotifications(list, emptyState, data.data ?? []);
            unreadCount = data.unread_count ?? 0;
            updateBadge(badge, unreadCount);
            hasLoaded = true;
        } catch (error) {
            console.error('Gagal memuat notifikasi', error);
        }
    };

    const markAllAsRead = async () => {
        try {
            await axios.post('/notifications/mark-as-read');
            unreadCount = 0;
            updateBadge(badge, unreadCount);
        } catch (error) {
            console.error('Gagal menandai notifikasi', error);
        }
    };

    toggle.addEventListener('click', () => {
        if (!hasLoaded) {
            fetchNotifications();
        }
    });

    if (markReadButton) {
        markReadButton.addEventListener('click', (event) => {
            event.preventDefault();
            markAllAsRead();

            Array.from(list.children).forEach((item) => {
                const timeLabel = item.querySelector('.text-xs.text-gray-400');
                if (timeLabel) {
                    timeLabel.textContent = 'Sudah dibaca';
                }
            });
        });
    }

    setupRealtime(userId, (notification) => {
        unreadCount += 1;
        updateBadge(badge, unreadCount);

        if (list && hasLoaded) {
            const element = createNotificationItem(notification);
            list.prepend(element);
            if (emptyState) {
                emptyState.classList.add('hidden');
            }
        }
    });
});
