<template>
    <div class="col-4 mx-auto">
        <h1 class="text-center my-5">Modification des informations</h1>
        <form class="row g-3 needs-validation" @submit.prevent="validNewDataUser(userStore.user.id)">
            <div class="row mx-auto">
                <label for="pseudo" class="form-label">Pseudo</label>
                <div class="input-group has-validation">
                    <input v-model="pseudo" type="text" name="pseudo" class="form-control" id="pseudo">
                    <div class="invalid-feedback">
                        Please choose a pseudo.
                    </div>
                </div>
            </div>
            <div class="row mx-auto">
                <label for="email" class="form-label">Email</label>
                <div class="input-group has-validation">
                    <input v-model="email" type="email" name="email" class="form-control" id="email">
                    <div class="invalid-feedback">
                        Please choose a email.
                    </div>
                </div>
            </div>
            <div class="row mx-auto">
                <label for="oldPassword" class="form-label">Mot de passe actuel</label>
                <div class="input-group has-validation">
                    <input type="password" v-model="oldPassword" name="oldPassword" class="form-control"
                        id="oldPassword">
                    <div class="invalid-feedback">
                        Please choose a password.
                    </div>
                </div>
            </div>
            <div class="row mx-auto">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <div class="input-group has-validation">
                    <input type="password" v-model="password" name="password" class="form-control" id="password">
                    <div class="invalid-feedback">
                        Please choose a password.
                    </div>
                </div>
            </div>
            <div class="row mx-auto">
                <label for="password_confirmation" class="form-label">Confirmation du nouveau mot de passe</label>
                <div class="input-group has-validation">
                    <input name="password_confirmation" v-model="passwordConfirmation" type="password"
                        class="form-control" id="password_confirmation">
                    <div class="invalid-feedback">
                        Please choose a passwordConfirm.
                    </div>
                </div>
            </div>
            <div class="col-12">
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

            <div class="row mt-4 text-center mx-auto">
                <button class="btn btn-dark" type="submit">
                    <i v-if="isLoading" class="fa-solid fa-spinner fa-spin me-2"></i>
                    <span v-if="!isLoading">Modifier</span>
                </button>
                <div v-if="errorMessage" style="color: red;">{{ errorMessage }}</div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../stores/userStore';

const router = useRouter();
const isLoading = ref(false);
const email = ref("");
const pseudo = ref("");
const oldPassword = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const image = ref(null);
const userStore = useUserStore();
const errorMessage = ref("")
email.value = userStore.user.email;
pseudo.value = userStore.user.pseudo;

const onFileChange = (event) => {
    const target = event.target;
    image.value = target.files[0];
};

const validNewDataUser = (userId) => {
    isLoading.value = true;
    const formData = new FormData();
    formData.append('_method', 'put');
    if (password.value !== null && password.value !== '') {
        // if (oldPassword.value)
        if (password.value !== passwordConfirmation.value) {
            errorMessage.value = "Les mots de passe ne correspondent pas.";
            isLoading.value = false;
            return;
        } else {
            formData.append('password', password.value);
            formData.append('oldPassword', oldPassword.value);
            formData.append('password_confirmation', passwordConfirmation.value);
            console.log('Password OK')
        }
    } else {
        console.log('null')
    }
    console.log(formData)
    if (email.value && email.value !== '') {
        formData.append('email', email.value);
    }
    if (pseudo.value && pseudo.value !== '') {
        formData.append('pseudo', pseudo.value);
    }
    if (image.value) {
        formData.append('image', image.value);
    }
    if (formData) {
        let formDataEntriesCount = 0;
        for (const pair of formData.entries()) {
            formDataEntriesCount++;
        }
        if (formDataEntriesCount > 1) {
            axios.post(`http://localhost:8000/api/users/${userId}`, formData)
                .then(res => {
                    console.log("Success : " + res);
                    console.log(formData);
                    isLoading.value = false;
                    // router.go(0);
                })
                .catch(error => {
                    console.log(formData);
                    console.error('Error:', error);
                    isLoading.value = false;
                });
        } else {
            isLoading.value = false;
        }
    }
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