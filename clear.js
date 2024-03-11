    // Function to clear disabled states in localStorage
    function clearDisabledStates() {
        // Clear all items in localStorage that end with '_disabled'
        for (var key in localStorage) {
            if (key.endsWith('_disabled')) {
                localStorage.removeItem(key);
            }
        }
    }

