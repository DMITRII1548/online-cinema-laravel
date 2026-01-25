import AntDesign from '@expo/vector-icons/AntDesign'
import { Text, View } from 'react-native'

const Index = () => {
    return (
        <View className="flex-1 justify-center items-center">
            <Text className="text-white text-xl">MAIN</Text>
            <AntDesign name="home" size={24} color="#FFF" />
        </View>
    )
}

export default Index
