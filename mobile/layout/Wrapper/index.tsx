import React from 'react'
import { View } from 'react-native'
import Menu from '../Menu'
import { SafeAreaView } from 'react-native-safe-area-context'

type WrapperProps = {
    children: React.ReactNode
}

const Wrapper: React.FC<WrapperProps> = ({ children }) => {
    return (
        <View className="flex-1 bg-gray-900">
            <SafeAreaView className="flex-1">
                {children}

                <Menu />
            </SafeAreaView>
        </View>
    )
}

export default Wrapper