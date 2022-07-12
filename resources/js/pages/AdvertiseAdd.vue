<template>
    <b-card-group deck>
        <b-card header="Добавление объявления">

            <b-form @submit.prevent="onSubmit">
                <b-form-group label="Название:">
                    <b-form-input
                        v-model="form.title"
                        :state="form.errors.has('title') ? false : null"
                    ></b-form-input>

                    <b-form-invalid-feedback v-if="form.errors.has('title')" v-html="form.errors.get('title')"/>
                </b-form-group>

                <b-form-group label="Описание:">
                    <b-form-textarea
                        v-model="form.description"
                        :state="form.errors.has('description') ? false : null"
                        rows="3"
                        max-rows="6"
                    ></b-form-textarea>

                    <b-form-invalid-feedback v-if="form.errors.has('description')"
                                             v-html="form.errors.get('description')"/>
                </b-form-group>

                <b-form-group label="Цена:">
                    <b-form-input
                        v-model.number="form.price"
                        :state="form.errors.has('price') ? false : null"
                        type="number"
                    ></b-form-input>

                    <b-form-invalid-feedback v-if="form.errors.has('price')" v-html="form.errors.get('price')"/>

                </b-form-group>

                <b-form-group label="Добавить изображение:">
                    <b-form-row v-if="form.images.length">
                        <b-col sm="6">
                            <b-list-group class="mb-3">
                                <b-list-group-item v-for="(image, index) in form.images" :key="index">
                                    {{ image }}
                                    <b-icon icon="trash-fill" @click="removeImage(index)"></b-icon>
                                </b-list-group-item>
                            </b-list-group>
                        </b-col>
                    </b-form-row>

                    <b-form-row v-if="form.images.length < 3">
                        <b-col>
                            <b-form-input v-model="imageUrl"></b-form-input>
                        </b-col>
                        <b-col>
                            <b-button variant="outline-primary" @click="addImageUrl">Добавить</b-button>
                        </b-col>
                    </b-form-row>
                    <b-form-invalid-feedback :state="form.errors.has('images') ? false : null"
                                             v-html="form.errors.get('images')"/>
                </b-form-group>

                <b-button type="submit" variant="primary">Сохранить</b-button>
                <b-button variant="outline-primary" to="/">Назад</b-button>
            </b-form>
        </b-card>
    </b-card-group>
</template>

<script>
import Form from 'vform'

export default {
    data() {
        return {
            imageUrl: '',
            form: new Form({
                title: '',
                description: '',
                price: '',
                images: []
            })
        }
    },
    methods: {
        async onSubmit() {
            const {data: {data, status}} = await this.form.post('/api/advertisings')

            if (status === true) {
                this.$router.push({name: 'advertise.show', params: {id: data.id}})
            } else {
                alert('Ошибка создания объявления!')
            }
        },
        addImageUrl() {
            this.form.images.push(this.imageUrl)
            this.imageUrl = ''
        },
        removeImage(index) {
            this.form.images.splice(index, 1)
        }
    }
}
</script>
