class SystemTime {
    static async getCurrentTime() {
        try {
            const response = await fetch('ajax/get_system_time.php');
            const data = await response.json();
            return data.current_time;
        } catch (error) {
            console.error('Error fetching system time:', error);
            return new Date().toISOString().slice(0, 19).replace('T', ' ');
        }
    }

    static async getCurrentUser() {
        try {
            const response = await fetch('ajax/get_current_user.php');
            const data = await response.json();
            return data.username;
        } catch (error) {
            console.error('Error fetching current user:', error);
            return 'Unknown User';
        }
    }

    static startTimeUpdates(elementId) {
        setInterval(async () => {
            const currentTime = await this.getCurrentTime();
            document.getElementById(elementId).textContent = currentTime;
        }, 1000);
    }
}