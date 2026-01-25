import React from 'react'
import { View } from 'react-native'
import Menu from '../Menu'

type WrapperProps = {
    children: React.ReactNode
}

const Wrapper: React.FC<WrapperProps> = ({ children }) => {
    return (
        <View className="flex-1 bg-gray-900">
            {children}

            <Menu />
        </View>
    )
}

export default Wrapper
