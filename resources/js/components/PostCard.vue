<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <b>
                <p>{{ post.user.pseudo }}</p>
            </b>
            <i class=" text-secondary">Créé le : {{ formatDate(post.created_at) }}</i>
        </div>
        <div class="card-content">
            <img :src="`./images/${post.image}`" alt="Post Image" width="100%" data-bs-toggle="modal"
                :data-bs-target="`#exampleModal_${post.id}`" style="max-height: 600px; object-fit: cover;">

            <!-- Modal -->
            <div class="modal fade" :id="`exampleModal_${post.id}`" tabindex="-1"
                :aria-labelledby="`#exampleModalLabel_${post.id}`" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img :src="`./images/${post.image}`" alt="Post Image" width="100%">
                        </div>
                    </div>
                </div>
            </div>
            <p class="pt-4 px-3">{{ post.content }}</p>
            <p class="px-3"><b>#{{ formatTags(post.tags) }}</b></p>
        </div>
        <div class="card-footer d-flex justify-content-around align-items-center">
            <form @submit.prevent="addComment" method="post" class="d-flex justify-content-center">
                <input type="text" name="comment" id="comment" placeholder="Ajouter un commentaire"
                    class="form-control me-2">
                <span class="input-group-text" id="comment" type="submit">
                    <i class="fa-regular fa-paper-plane"></i>
                </span>

            </form>
            <DropdownActionsPost :post="post" />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import DropdownActionsPost from './DropdownActionsPost.vue';

defineProps({
    post: {
        type: Object,
        required: true
    }
});

const tags = ref("");
const content = ref("");
const userId = ref("");
const image = ref(null);

const formatTags = (tags) => {
    return tags.replace(/\s+/g, ' #');
};
const formatDate = (date) => {
    const dateF = new Date(date);
    return new Intl.DateTimeFormat('default', { dateStyle: 'long' }).format(dateF);
};



const addComment = () => {

}
</script>

<style scoped>
.card {
    width: 400px;
}
</style>