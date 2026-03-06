import { Movie } from "@/types/movie"
import React from "react"
import { Image, Text, View } from "react-native"

type MovieItemProps = {
    movie: Movie
}

const MovieItem: React.FC<MovieItemProps> = ({ movie }) => {
    return (
        <View className="gap-3 mb-3 p-4 rounded-lg border border-white">
            <Image
                source={{ uri: movie.image }}
                className="w-full h-48 rounded-lg"
                resizeMode="cover"
            />
            <Text className="text-white text-center text-xl font-semibold">
                {movie.title}
            </Text>
        </View>
    )
}

export default MovieItem