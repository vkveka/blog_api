<template>
    <div class="col-2 mx-auto">
        <h1 class="text-center my-5">Login</h1>
        <form class="row g-3 needs-validation" @submit.prevent="logIn">
            <div class="row mx-auto">
                <label for="email" class="form-label">Pseudo</label>
                <div class="input-group has-validation">
                    <input v-model="email" type="email" class="form-control" id="email" required>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
            </div>
            <div class="row mx-auto">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group has-validation">
                    <input v-model="password" type="password" class="form-control" id="password" required>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
            </div>

            <div class="row mt-4 text-center mx-auto">
                <button class="btn btn-dark" type="submit">
                    <i v-if="isLoading" class="fa-solid fa-spinner fa-spin me-2"></i>
                    <span v-if="!isLoading">Publier</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const email = ref('');
const password = ref('');
const isLoading = ref(false);

const logIn = () => {
    isLoading.value = true;

    axios.get('/sanctum/csrf-cookie')
        .then(() => {
            return axios.post('api/login', {
                email: email.value,
                password: password.value
            });
        })
        .then(response => {
            console.log('Logged in successfully', response.data);
            window.location.href = response.data.redirect;
        })
        .catch(error => {
            console.error('Error logging in:', error);
        })
        .finally(() => {
            isLoading.value = false;
        });
};
</script>

<style lang="scss" scoped></style>