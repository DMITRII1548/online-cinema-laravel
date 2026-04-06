import AsyncStorage from '@react-native-async-storage/async-storage';

const useStorage = () => {
    const getItem = async (key: string) => {
        try {
            const jsonValue = await AsyncStorage.getItem(key)

            if (jsonValue !== null) {
                const value = JSON.parse(jsonValue)
                return value
            } else {
                return null
            }
        } catch (e) {
            console.error(e)
            return null
        }
    }

    const setItem = async (key: string, value: unknown) => {
        try {
            const jsonValue = JSON.stringify(value);
            await AsyncStorage.setItem(key, jsonValue);
        } catch (e) {
            console.error(e)
        }
    }

    return {
        getItem,
        setItem
    }
}

export default useStorage