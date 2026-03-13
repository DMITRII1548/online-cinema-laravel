import { Stack } from 'expo-router'
import '../global.css'
import { COLORS } from '@/constants/colors'
import Wrapper from '@/layout/Wrapper'

const RootLayout = () => {
    return (
        <Wrapper>
            <Stack
                screenOptions={{
                    headerShown: false,
                    contentStyle: { backgroundColor: COLORS.BACKGROUND },
                }}
            />
        </Wrapper>
    )
}

export default RootLayout
