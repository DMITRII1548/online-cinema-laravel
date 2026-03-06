import { Movie } from '@/types/movie'
import React from 'react'
import { FlatList, View } from 'react-native'
import MovieItem from '../MovieItem'

type MovieItemsProps = {
    movies: Movie[],
}

const MovieItems: React.FC<MovieItemsProps> = ({movies}) => {
    return (
        <View className="flex-1 gap-3">
            <FlatList
                data={movies} 
                keyExtractor={(item) => item.id.toString()} 
                renderItem={({ item }) => 
                    <MovieItem
                        movie={item}
                    />
                }
            /> 
        </View>
    )
}

export default MovieItems
