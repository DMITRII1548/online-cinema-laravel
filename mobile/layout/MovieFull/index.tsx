import CustomVideoPlayer from '@/components/CustomVideoPlayer'
import { COLORS } from '@/constants/colors'
import useStorage from '@/hooks/useStorage'
import { Movie } from '@/types/movie'
import Fontisto from '@expo/vector-icons/Fontisto'
import React, { useEffect, useState } from 'react'
import { Image, Text, TouchableOpacity, View } from 'react-native'

type MovieFullProps = {
    movie: Movie
}

const MovieFull: React.FC<MovieFullProps> = ({ movie }) => {
    const { getItem, setItem } = useStorage()

    const [isFavor, setIsFavor] = useState<boolean>(false)

    const [favors, setFavors] = useState<number[]>([])

    const getFavors = async () => {
        let item = await getItem('favor_movies')

        if (! item) {
            item = []
        }

        setFavors(item)
    }

    const setToFavors = async (id: number) => {
        let updatedFavors: number[]

        if (checkIdIsFavor(id, favors)) {
            updatedFavors = favors.filter(favorId => favorId !== id)
        } else {
            updatedFavors = [...favors, id]
        }

        setFavors(updatedFavors)
        await setItem('favor_movies', updatedFavors)
    }

    const checkIdIsFavor = (id: number, favors: number[]): boolean => {
        return favors.includes(id)
    }

    const toggleFavor = async (id: number) => {
        await setToFavors(id)
    }

    useEffect(() => {
        getFavors()
    }, [])

    useEffect(() => {
        setIsFavor(checkIdIsFavor(movie.id, favors))
    }, [favors])

    return (
        <View className="p-4 gap-4">
            <Text className="text-white text-center text-3xl font-bold">{movie.title}</Text>

            <Image
                source={{ uri: movie.image }}
                className="w-full h-64 rounded-xl"
                resizeMode="cover"
            />

            <Text className="text-white text-lg">{movie.description}</Text>


            <View className="flex flex-row gap-3 items-center">
                <Text className="text-white text-lg font-bold">Watch later:</Text>

                <TouchableOpacity
                    onPress={() => { toggleFavor(movie.id) }}
                >
                    <Fontisto name="favorite" size={22} color={isFavor ? COLORS.WHITE : COLORS.GRAY} />
                </TouchableOpacity>
            </View>

        

            <CustomVideoPlayer video={movie.video.video} />
        </View>
    )
}

export default MovieFull
