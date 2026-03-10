import CustomVideoPlayer from "@/components/CustomVideoPlayer"
import { Movie } from "@/types/movie"
import React from "react"
import { Image, Text, View } from "react-native"

type MovieFullProps = {
    movie: Movie
}

const MovieFull: React.FC<MovieFullProps> = ({ movie }) => {
    return (
        <View className="p-4 gap-4">
            <Text className="text-white text-center text-3xl font-bold">
                {movie.title}
            </Text>

            <Image
                source={{ uri: movie.image }}
                className="w-full h-64 rounded-xl"
                resizeMode="cover"
            />

            <Text className="text-white text-lg">
                {movie.description}
            </Text>

            <CustomVideoPlayer video={movie.video.video} />
        </View>
    )
}

export default MovieFull