import { COLORS } from '@/constants/colors'
import { ROUTES } from '@/constants/routes'
import AntDesign from '@expo/vector-icons/AntDesign'
import MaterialIcons from '@expo/vector-icons/MaterialIcons'
import { Link } from 'expo-router'
import { View } from 'react-native'

const Menu = () => {
    return (
        <View className="bg-gray-800 h-[60] p-4 border-t border-white">
            <View className="flex-1 flex-row justify-between items-center px-4">
                <Link href={ROUTES.HOME}>
                    <AntDesign name="home" size={24} color={COLORS.WHITE} />
                </Link>

                <Link href={ROUTES.MOVIE_FAVOURITES}>
                    <MaterialIcons name="favorite" size={24} color={COLORS.WHITE} />
                </Link>
            </View>
        </View>
    )
}

export default Menu
