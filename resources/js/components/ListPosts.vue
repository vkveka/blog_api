<template>
    <div class="pt-5">
        <v-row>
            <AddPost />
            <div v-masonry="containerId" class="masonry-container" transition-duration="1s" item-selector=".item">
                <div v-masonry-tile class="item" v-for="post in posts" :key="post.id">
                    <PostCard :post="post" />
                </div>
            </div>
        </v-row>
    </div>
</template>



<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import PostCard from './PostCard.vue';
import AddPost from './AddPost.vue';

const posts = ref([]);

const recupPosts = async () => {
    await axios.get('http://localhost:8000/api/posts')
        .then((res) => {
            posts.value = res.data.posts;
            console.log(res.data.posts)
            // console.log(posts.value)
        })
        .catch((error) => {
            console.log(error.response.data.message)
        })
};

onMounted(() => {
    recupPosts();
});
</script>

<style scoped>
.item {
    margin: 10px;
}

.masonry-container {
    padding-left: 50px;
    /* max-width: 85%; */
    /* left: 15%; */


}

[v-masonry] {
    width: 100%;
    /* max-width: 1200px; */
}
</style>