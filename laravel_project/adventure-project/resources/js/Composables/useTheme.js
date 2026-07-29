import { ref } from 'vue';

const darkMode = ref(localStorage.getItem('theme') === 'dark');

export function useTheme() {
    function toggleTheme() {
        darkMode.value = !darkMode.value;

        if (darkMode.value) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }

    function loadTheme() {
        if (darkMode.value) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }

    return {
        darkMode,
        toggleTheme,
        loadTheme,
    };
}
