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
            <div class="modal fade" :id="`exampleModal_${post.id}`" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true" style="z-index: 9999999999;">
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



            <p class="py-4 px-3">{{ post.content }}</p>
        </div>
        <div class="card-footer">
            <h6>
                <b>#{{ formatTags(post.tags) }}</b>
            </h6>
        </div>
    </div>
</template>

<script setup>
// import { defineProps } from 'vue';

defineProps({
    post: {
        type: Object,
        required: true
    }
});


const formatTags = (tags) => {
    return tags.replace(/\s+/g, ' #');
};

const formatDate = (date) => {
    const dateF = new Date(date);
    return new Intl.DateTimeFormat('default', { dateStyle: 'long' }).format(dateF);
};
</script>

<style scoped>
.card {
    width: 400px;
}
</style>