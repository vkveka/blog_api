<template>
    <div>
        <i class="fa-regular fa-pen-to-square me-2" data-bs-toggle="modal" :data-bs-target="`#updatePost_${post.id}`"
            style="color: #f7c12a; font-size: 1.3em;"></i>

        <div class="modal fade" :id="`updatePost_${post.id}`" tabindex="-1"
            :aria-labelledby="`updatePostLabel_${post.id}`" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form @submit.prevent="updatePost(post.id)">
                        <div class="modal-header">
                            <b>Modification du post</b>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea v-model="newContent" name="content" id="content" class="form-control"
                                style="height: 200px;"></textarea>
                            <input v-model="newTags" type="text" class="form-control mt-3">
                            <input @change="onFileUpdate" type="file" name="image" id="image" class="form-control mt-3">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-dark" data-bs-dismiss="modal">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <i class="fa-regular fa-trash-can" data-bs-toggle="modal" :data-bs-target="`#removePost_${post.id}`"
            style="color: red; font-size: 1.3em;"></i>
        <div class="modal fade" :id="`removePost_${post.id}`" tabindex="-1"
            :aria-labelledby="`removePostLabel_${post.id}`" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <b>Suppression du post</b>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Etes-vous sûr(e) de vouloir supprimer ce post définitivement ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" @click="removePost(post.id)" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { ref } from 'vue';
const router = useRouter();

const props = defineProps({
    post: {
        type: Object,
        required: true
    }
})

const newTags = ref(props.post.tags);
const newContent = ref(props.post.content);
const newImage = ref(null);


const onFileUpdate = (event) => {
    const target = event.target;
    if (target.files && target.files[0]) {
        newImage.value = target.files[0];
        // console.log(newImage.value)
    }
};

const updatePost = (postId) => {
    const formData = new FormData();
    formData.append('_method', 'put');
    formData.append('content', newContent.value);
    formData.append('tags', newTags.value);
    if (newImage.value) {
        formData.append('image', newImage.value);
    }
    console.log(formData)

    axios.post(`/api/posts/${postId}`, formData)
        .then(res => {
            console.log("Success : " + res);
            router.go(0);
        })
        .catch(error => {
            console.error('Error:', error);
        });

}


const removePost = (postId) => {
    axios.delete(`http://localhost:8000/api/posts/${postId}`)
        .then(res => {
            console.log(" Success : " + res);
            router.go(0);
        })
        .catch(error => {
            console.error('Error:', error);
        })
}

</script>

<style scoped>
i:hover {
    filter: brightness(0.7);
}

i {
    cursor: pointer;
    transition: 0.3s;
}
</style>