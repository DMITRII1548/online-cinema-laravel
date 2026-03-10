import { Video } from "@/types/video"
import React from "react"
import { View, StyleSheet } from "react-native"
import { useVideoPlayer, VideoView } from 'expo-video';

type CustomVideoPlayerProps = {
    video: string
}

const CustomVideoPlayer: React.FC<CustomVideoPlayerProps> = ({ video }) => {
    const player = useVideoPlayer(video, player => {
        player.loop = true;
        player.play();
    });
    
    return (
        <View className="w-full h-56 rounded-xl overflow-hidden">
            <VideoView
                style={styles.video}
                player={player}
                allowsFullscreen
                allowsPictureInPicture
                nativeControls
            />
        </View>
    )
}

const styles = StyleSheet.create({
    video: {
        flex: 1,
    }
})

export default CustomVideoPlayer