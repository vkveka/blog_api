<template>
    <div style="width: 100%;">
        <form @submit.prevent="addPost" class="row">
            <div class="row col-6">
                <div class="col-12">
                    <textarea v-model="content" id="textarea" placeholder="Enter something..." class="form-control mt-2"
                        style=" height: 200px"></textarea>
                </div>
                <div class="col-6">
                    <input v-model="tags" type="text" name="tags" id="tags" placeholder="Tags"
                        class="form-control col-3 mt-2">
                </div>
                <div class="col-6">
                    <input v-model="userId" type="text" name="user_id" id="user_id" placeholder="User Id"
                        class="form-control mt-2 col-3">
                </div>
            </div>
            <div class="col-3">
                <div class="input-group mb-3 mt-2 col-3">
                    <div class="dropzone-container">
                        <label for="image" class="dropzone-label">
                            <div class="dropzone-content">
                                <svg class="dropzone-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="dropzone-text"><span class="dropzone-text-bold">Click to upload</span> or drag
                                    and
                                    drop</p>
                                <p class="dropzone-subtext">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="image" type="file" class="hidden" @change="onFileChange" name="image" />
                        </label>
                    </div>
                </div>

            </div>
            <div class="row">
                <button type="submit" class="btn btn-dark mt-1 col-1 ms-2">
                    <i v-if="isLoading" class="fa-solid fa-spinner fa-spin me-2"></i>
                    <span v-if="!isLoading">Publier</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const tags = ref("");
const content = ref("");
const userId = ref("");
const image = ref(null);
const isLoading = ref(false);

const onFileChange = (event) => {
    const target = event.target;
    if (target.files && target.files[0]) {
        image.value = target.files[0];
    }
};


const addPost = async () => {
    const formData = new FormData();
    formData.append('content', content.value);
    formData.append('tags', tags.value);
    formData.append('user_id', userId.value);
    if (image.value) {
        formData.append('image', image.value);
    }

    isLoading.value = true;

    axios.post('http://localhost:8000/api/posts', formData)
        .then(res => {
            console.log("Success : " + res);
            router.go(0);
        })
        .catch(error => {
            console.error('Error:', error);
        })
        .finally(() => {
            isLoading.value = false;
        });
}
</script>

<style scoped>
.row {
    margin: 0;
}

.dropzone-container {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

.dropzone-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 16rem;
    /* 64 * 0.25rem */
    border: 2px dashed #d1d5db;
    /* gray-300 */
    border-radius: 0.5rem;
    /* rounded-lg */
    cursor: pointer;
    background-color: #f9fafb;
    /* gray-50 */
    transition: background-color 0.3s, border-color 0.3s;
}

.dropzone-label:hover {
    background-color: #f3f4f6;
    /* hover:bg-gray-100 */
}

.dropzone-label.dark:hover {
    background-color: #1f2937;
    /* dark:hover:bg-gray-800 */
}

.dropzone-label.dark {
    background-color: #374151;
    /* dark:bg-gray-700 */
    border-color: #4b5563;
    /* dark:border-gray-600 */
}

.dropzone-label.dark:hover {
    border-color: #6b7280;
    /* dark:hover:border-gray-500 */
    background-color: #4b5563;
    /* dark:hover:bg-gray-600 */
}

.dropzone-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 1.25rem;
    /* pt-5 */
    padding-bottom: 1.5rem;
    /* pb-6 */
}

.dropzone-icon {
    width: 2rem;
    /* 8 * 0.25rem */
    height: 2rem;
    /* 8 * 0.25rem */
    margin-bottom: 1rem;
    /* mb-4 */
    color: #6b7280;
    /* text-gray-500 */
}

.dropzone-label.dark .dropzone-icon {
    color: #9ca3af;
    /* dark:text-gray-400 */
}

.dropzone-text {
    margin-bottom: 0.5rem;
    /* mb-2 */
    font-size: 0.875rem;
    /* text-sm */
    color: #6b7280;
    /* text-gray-500 */
}

.dropzone-label.dark .dropzone-text {
    color: #9ca3af;
    /* dark:text-gray-400 */
}

.dropzone-text-bold {
    font-weight: 600;
    /* font-semibold */
}

.dropzone-subtext {
    font-size: 0.75rem;
    /* text-xs */
    color: #6b7280;
    /* text-gray-500 */
}

.dropzone-label.dark .dropzone-subtext {
    color: #9ca3af;
    /* dark:text-gray-400 */
}

.hidden {
    display: none;
}
</style>