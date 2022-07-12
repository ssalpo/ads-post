<template>
    <b-card-group deck>
        <b-card header="Просмотр объявления">
            <div v-if="isLoading">Загружается...</div>
            <div v-else>
                <router-link to="/">назад к списку</router-link>

                <table class="table-bordered mt-3" cellpadding="20">
                    <tr>
                        <td><b>Название:</b></td>
                        <td>{{ advertising.title }}</td>
                    </tr>
                    <tr v-if="advertising.description !== undefined">
                        <td><b>Описание:</b></td>
                        <td>{{ advertising.description }}</td>
                    </tr>
                    <tr>
                        <td><b>Цена:</b></td>
                        <td>{{ advertising.price }}</td>
                    </tr>
                    <tr v-if="advertising.images !== undefined">
                        <td><b>Изображения:</b></td>
                        <td>
                            <ul>
                                <li v-for="image in advertising.images">{{ image.url }}</li>
                            </ul>
                        </td>
                    </tr>
                </table>

                <b-button variant="outline-primary" class="mt-3" v-if="!isAdditionalFieldShow"
                          @click="showAdditionalFields">
                    Показать дополнительные поля
                </b-button>
            </div>
        </b-card>
    </b-card-group>
</template>

<script>
export default {
    data: () => ({
        isLoading: true,
        additionalFields: [],
        isAdditionalFieldShow: false,
        advertising: {}
    }),
    created() {
        this.getData()
    },
    computed: {
        additionalFieldsQueryString() {
            return this.additionalFields.length
                ? this.additionalFields.map((item) => `fields[]=${encodeURIComponent(item)}`).join("&")
                : ''
        }
    },
    methods: {
        getData() {
            axios.get(`/api/advertisings/${this.$route.params.id}?${this.additionalFieldsQueryString}`)
                .then(({data: {data}}) => {
                    this.advertising = data
                    this.isLoading = false
                })
        },
        showAdditionalFields() {
            this.additionalFields = ['description', 'images'];
            this.isAdditionalFieldShow = true
            this.getData();
        }
    }
}
</script>
