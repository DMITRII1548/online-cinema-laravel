import { Video } from "./video"

export interface Movie {
    id: number
    title: string
    description: string
    image: string
    video: Video
}