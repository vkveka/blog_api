<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <b>
                <p>{{ post.user.pseudo }}</p>
            </b>
            <i class=" text-secondary">Créé le : {{ formatDate(post.created_at) }}</i>
        </div>
        <div class="card-content">
            <div v-if="post.image">
                <img :src="`./images/${post.image}`" alt="Post Image" width="100%" data-bs-toggle="modal"
                    :data-bs-target="`#exampleModal_${post.id}`" style="max-height: 600px; object-fit: cover;">
            </div>

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
        <div class="card-footer" style="display: flex; flex-direction: column;">
            <div class=" d-flex justify-content-around align-items-center" v-if="(userStore.user)">
                <form @submit.prevent="addComment(post.id)" method="post" class="d-flex justify-content-center">

                    <input v-model="content" type="text" name="comment" :id="`comment_${post.id}`"
                        placeholder="Ajouter un commentaire" class="form-control " style="border-radius: 5px 0 0 5px;">

                    <span @click="triggerFileInput(post.id)" class="input-group-text span_add_comment"
                        style="border-radius: 0 0 0 0;">
                        <i class="fa-regular fa-image" style="color: #95ca0a;"></i>
                    </span>
                    <div style="position: relative;">
                        <input type="file" @change="onFileChange" :dataPostId="post.id" class="form-control hidden"
                            :id="`file_comment_${post.id}`">
                        <span :id="`spanImage${post.id}`"
                            style="border-radius: 5vh; font-size: 0.6em; font-weight: bold; color: white; background-color: red; display: none; position: absolute; left: -20px; top: 5px; height: 15px; width: 15px;"
                            class="text-center">1</span>
                    </div>

                    <span class="input-group-text span_add_comment" style="border-radius: 0 5px 5px 0;">
                        <button style="all: unset;" type="submit">
                            <i class="fa-regular fa-paper-plane" style="color: #1363be;"></i>
                        </button>
                    </span>

                </form>
                <DropdownActionsPost :post="post" style="display:flex; flex-direction: row;" />
            </div>
            <div class="text-center">
                <a @click="getComments"
                    style="font-size: 0.9em; color: black; text-decoration: none; font-weight: bold;"
                    data-bs-toggle="offcanvas" :href="`#offcanvasExample${post.id}`" role="button"
                    aria-controls="offcanvasExample">
                    Voir les commentaires
                </a>
                <div class="offcanvas offcanvas-start" tabindex="-1" :id="`offcanvasExample${post.id}`"
                    :aria-labelledby="`offcanvasExample${post.id}`">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" :id="`offcanvasExampleLabel${post.id}`">Commentaires</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div>
                            <li class="list-group-item" v-for="comment in post.comments" :key="comment.id">
                                <div class="row">
                                    <div class="text-start col-6">
                                        <img :src="`images/${comment.user.image}`" alt="img user" height="35px"
                                            width="35px" style="border-radius: 5vh; margin-right: 10px;">
                                        <b>{{ comment.user.pseudo }}</b>
                                    </div>
                                    <div class="text-end col-6">
                                        <i class="text-secondary">{{ formatDate(comment.created_at) }}</i>
                                    </div>
                                </div>
                                <div class="text-start">
                                    <p :id="`commentContent_${comment.id}`">{{ comment.content }}</p>
                                    <form @submit.prevent="updateComment(comment.id, post.id)"
                                        :id="`formCommentUpdate_${comment.id}`" class="d-none">
                                        <input class="form-control my-2" type="text" name="content"
                                            :id="`updateCommentContent_${comment.id}`" v-model="updateCommentContent">
                                        <input class="form-control my-2" type="file" name="image"
                                            :id="`updateCommentImage_${comment.id}`" @change="onFileChangeUpdate">
                                        <span :id="`spanShowUpdateButton_${comment.id}`"
                                            class="input-group-text span_add_comment my-2"
                                            style="border-radius: 0 5px 5px 0;">
                                            <button style="all: unset;" type="submit" class="mx-auto">
                                                <i class="fa-regular fa-paper-plane" style="color: #1363be;"></i>
                                                Enregistrer
                                                les modifications
                                            </button>
                                        </span>
                                    </form>
                                    <img v-if="comment.image" :src="`images/${comment.image}`" alt="img comment"
                                        style="max-width: 50%;"></img>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6"
                                        v-if="(userStore.user && (comment.user_id == userStore.user.id))">
                                        <div @click="showUpdateInput(comment.id, comment.content)"
                                            :id="`editUpdateButton_${comment.id}`" class="text-start">
                                            <button type="button" class="btn btn-outline-warning">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                        </div>
                                        <div @click="hideUpdateInput(comment.id, comment.content)"
                                            :id="`hideUpdateButton_${comment.id}`" class="text-start d-none">
                                            <button type="button" class="btn btn-outline-secondary">
                                                <i class="fa-solid fa-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <form @submit.prevent="deleteComment(comment.id)" class="text-end col-6"
                                        v-if="(userStore.user && (comment.user_id == userStore.user.id || userStore.user.role_id == 2))">
                                        <button type="submit" class="btn btn-outline-danger"
                                            style=" font-size: 0.7em;">Supprimer</button>
                                    </form>
                                </div>
                                <hr>

                            </li>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import DropdownActionsPost from './ActionsPost.vue';
import { useUserStore } from '../stores/userStore';
import { useRouter } from 'vue-router';

defineProps({
    post: {
        type: Object,
        required: true
    }
});

const router = useRouter()
const userStore = useUserStore();
const userId = userStore.user ? userStore.user.id : null;
const content = ref("");
const image = ref(null);

//UPDATE COMMENT
const updateCommentContent = ref("")
const updateCommentImage = ref("")

const formatTags = (tags) => {
    return tags.replace(/\s+/g, ' #');
};
const formatDate = (date) => {
    const dateF = new Date(date);
    return new Intl.DateTimeFormat('default', { dateStyle: 'long' }).format(dateF);
};

const onFileChange = (event) => {
    const target = event.target;
    const postId = event.target.attributes.dataPostId.value;
    // console.log(postId)
    console.log(event)
    const spanImage = document.getElementById(`spanImage${postId}`)
    if (target.files && target.files[0]) {
        image.value = target.files[0];
        spanImage.style.display = 'block';
    }
    console.log(image.value)
};

const onFileChangeUpdate = (event) => {
    const targetUpdate = event.target;
    if (targetUpdate.files && targetUpdate.files[0]) {
        updateCommentImage.value = targetUpdate.files[0];
    }
};

const triggerFileInput = (postId) => {
    const fileInput = document.getElementById(`file_comment_${postId}`);
    if (fileInput) {
        fileInput.click();
    }
};

const addComment = (id) => {
    const formData = new FormData();
    formData.append('content', content.value)
    formData.append('post_id', id)
    formData.append('user_id', userId)
    if (image.value) {
        formData.append('image', image.value);
    }
    axios.post('/api/comments/', formData)
        .then((res) => {
            console.log('Success :' + res)
            router.go(0)
        })
        .catch((error) => {
            console.log('Erreur :' + error)
        })
}

const showUpdateInput = (id, content) => {
    const formUpdate = document.getElementById('formCommentUpdate_' + id)
    const newInputUpdate = document.getElementById('updateCommentContent_' + id)
    const commentContent = document.getElementById('commentContent_' + id)
    const editButton = document.getElementById('editUpdateButton_' + id)
    const closeButton = document.getElementById('hideUpdateButton_' + id)
    closeButton.classList.remove('d-none')
    formUpdate.classList.remove('d-none');
    newInputUpdate.value = content
    commentContent.classList.add('d-none');
    editButton.classList.add('d-none');
}
const hideUpdateInput = (id) => {
    const formUpdate = document.getElementById('formCommentUpdate_' + id)
    const commentContent = document.getElementById('commentContent_' + id)
    const editButton = document.getElementById('editUpdateButton_' + id)
    const closeButton = document.getElementById('hideUpdateButton_' + id)
    closeButton.classList.add('d-none')
    formUpdate.classList.add('d-none');
    commentContent.classList.remove('d-none');
    editButton.classList.remove('d-none');
}

const updateComment = (commentId, postId) => {
    const newInputUpdate = document.getElementById('updateCommentContent_' + commentId)
    const formData = new FormData();
    formData.append('_method', 'put');
    formData.append('user_id', userId);
    formData.append('post_id', postId);
    if (updateCommentContent.value && updateCommentContent.value !== "") {
        formData.append('content', updateCommentContent.value);
    } else {
        formData.append('content', newInputUpdate.value);
    }
    if (updateCommentImage.value) {
        formData.append('image', updateCommentImage.value);
    }
    console.log(formData)
    axios.post(`/api/comments/${commentId}`, formData)
        .then(res => {
            console.log("Success : " + res);
            router.go(0);
        })
        .catch(error => {
            console.error('Error:', error);
            console.log(formData)
        });
}

const deleteComment = (commentId) => {
    axios.delete(`/api/comments/${commentId}`)
        .then((res) => {
            console.log(res.data)
            router.go(0)
        })
        .catch((err) => {
            console.log(err.data)
        })
}
</script>

<style scoped>
.card {
    width: 400px;
}

.span_add_comment {
    cursor: pointer;
}

.hidden {
    display: none;
}
</style>