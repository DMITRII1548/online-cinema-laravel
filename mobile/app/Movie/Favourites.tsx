import useStorage from '@/hooks/useStorage'
import MovieItems from '@/layout/MovieItems'
import { Movie } from '@/types/movie'
import axios from 'axios'
import { useEffect, useState } from 'react'
import { Text, View } from 'react-native'

const Favourites = () => {
    const { getItem } = useStorage()

    const [movies, setMovies] = useState<Movie[]>([])
    const [favors, setFavors] = useState<number[]>([])
    const [loading, setLoading] = useState<boolean>(false)
    const [loadMore, setLoadMore] = useState<boolean>(false)

    const getFavors = async () => {
        let item = await getItem('favor_movies')

        if (!item) {
            item = []
        }

        setFavors(item)
    }

    const getFavorMovies = async (ids: number[]) => {
        const apiUrl = process.env.EXPO_PUBLIC_API_URL
        setLoading(true)

        try {
            const requests = ids.map(id => axios.get(`${apiUrl}/movies/${id}`))
            const responses = await Promise.all(requests)
            const fetchedMovies = responses.map(res => res.data)

            setMovies(fetchedMovies)
        } catch (e) {
            console.error(e)
        } finally {
            setLoading(false)
        }
    }

    useEffect(() => {
        getFavors()
    }, [])

    useEffect(() => {
        if (favors.length > 0) {
            getFavorMovies(favors)
        }
    }, [favors])

    return (
        <View className="flex-1 justify-center items-center p-4">
            <Text className="text-white text-xl font-bold text-center">Watch later</Text>

            {favors.length === 0 && (
                <Text className="text-white text-xl">You didn't add movies to watch later</Text>
            )}

            {favors.length > 0 && (
                <MovieItems movies={movies} onLoadMore={loadMore} loading={loading} />
            )}
        </View>
    )
}

export default Favourites