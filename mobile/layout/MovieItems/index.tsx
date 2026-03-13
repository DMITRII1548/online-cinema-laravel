import { Movie } from '@/types/movie'
import React from 'react'
import { ActivityIndicator, FlatList, View } from 'react-native'
import MovieItem from '../MovieItem'

type MovieItemsProps = {
    movies: Movie[]
    onLoadMore: () => void
    loading: boolean
}

const MovieItems: React.FC<MovieItemsProps> = ({ movies, onLoadMore, loading }) => {
    return (
        <View className="flex-1 gap-3">
            <FlatList
                data={movies}
                keyExtractor={item => item.id.toString()}
                onEndReachedThreshold={0.5}
                onEndReached={onLoadMore}
                renderItem={({ item }) => <MovieItem movie={item} />}
                ListFooterComponent={
                    loading ? <ActivityIndicator color="white" className="py-4" /> : null
                }
            />
        </View>
    )
}

export default MovieItems
