import { useEffect, useState } from 'react'
import { Text, View } from 'react-native'
import axios from 'axios'
import MovieItems from '@/layout/MovieItems'

type Movie = {
    id: number
    title: string
    description: string
    image: string
    video: {
        id: number
        video: string
    }
}

const Index = () => {
    const [movies, setMovies] = useState<Movie[]>([])
    const [error, setError] = useState(false)
    const [loading, setLoading] = useState(false)
    const [page, setPage] = useState(1)
    const [lastPage, setLastPage] = useState(1)

    const getMovies = async (pageNumber: number) => {
        const apiUrl = process.env.EXPO_PUBLIC_API_URL

        if (!apiUrl) {
            setError(true)
            return
        }

        setLoading(true)
        setError(false)

        try {
            const response = await axios.get(`${apiUrl}/movies`, {
                params: { page: pageNumber },
            })

            setMovies(prev => 
                pageNumber === 1 
                    ? response.data.data 
                    : [...prev, ...response.data.data]
            )

            setPage(response.data.current_page)
            setLastPage(response.data.last_page)
        } catch (e) {
            console.log(e)
            setError(true)
        } finally {
            setLoading(false)
        }
    }

    const loadMore = () => {
        if (page < lastPage) {
            getMovies(page + 1)
        }
    }

    useEffect(() => {
        getMovies(1)
    }, [])

    return (
        <View className="flex-1 p-4">
            {!error && movies.length > 0 && (
                <MovieItems 
                    movies={movies} 
                    loading={loading}
                    onLoadMore={loadMore}
                />
            )}

            {loading && movies.length === 0 && (
                <Text className="text-white text-xl text-center">
                    Загрузка...
                </Text>
            )}

            {!loading && !error && movies.length === 0 && (
                <Text className="text-white text-xl text-center">
                    Фильмы не найдены
                </Text>
            )}

            {error && (
                <Text className="text-white text-xl text-center">
                    Нет сети
                </Text>
            )}
        </View>
    )
}

export default Index
