import MovieFull from '@/layout/MovieFull'
import { Movie } from '@/types/movie'
import axios from 'axios'
import { useLocalSearchParams } from 'expo-router'
import { useEffect, useState } from 'react'
import { Text, View, Image, ScrollView } from 'react-native'

const Show = () => {
    const { id } = useLocalSearchParams()
    const [isLoaded, setIsLoaded] = useState<boolean>(false)
    const [movie, setMovie] = useState<Movie>()
    
    const getMovie = async (id: number) => {
        const apiUrl = process.env.EXPO_PUBLIC_API_URL


        try {
            const response = await axios.get(`${apiUrl}/movies/${id}`)

            setMovie(response.data)
            setIsLoaded(true)
        } catch (e) {
            setIsLoaded(false)
        }
    }

    useEffect(() => {
        if (! id) return 

        getMovie(id)
    }, [id])
    
    return (
        <ScrollView>
            {
                ! isLoaded && 
                (<Text className="text-white text-xl">Загрузка</Text>)
            }

            {
                isLoaded &&
                (
                    <MovieFull movie={movie} />
                )
            }
        </ScrollView>
    )
}

export default Show
