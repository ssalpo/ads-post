<template>
    <b-card-group deck>
        <b-card header="Список объявлений">
            <b-button variant="success" :to="{name: 'advertise.add'}" class="mb-3">Добавить</b-button>

            <b-table
                head-variant="dark"
                small
                :no-local-sorting="true"
                @sort-changed="sortingChanged"
                :items="items"
                :fields="fields"
                responsive="sm"
                bordered
            >
                <template v-slot:cell(show)="{ item }">
                    <router-link :to="{name: 'advertise.show', params: {id: item.id}}">показать</router-link>
                </template>

            </b-table>

            <b-pagination
                size="sm"
                v-model="pagination.currentPage"
                :total-rows="pagination.rows"
                :per-page="pagination.perPage"
                @change="this.getData"
            ></b-pagination>
        </b-card>
    </b-card-group>
</template>

<script>
import {textLimit} from "../utils";

export default {
    data() {
        return {
            fields: [
                {key: 'id', label: 'ID'},
                {key: 'main_image_url', label: 'Главное фото', formatter: (v) => v || '-'},
                {key: 'title', label: 'Название', formatter: (v) => textLimit(v, 40)},
                {key: 'price', label: 'Цена', sortable: true},
                {key: 'created_at', label: 'Дата создания', sortable: true},
                {key: 'show'},
            ],
            items: [],
            pagination: {
                currentPage: 1,
                rows: 0,
                perPage: 10
            },
            sort: {}
        }
    },
    created() {
        this.getData();
    },
    methods: {
        getData(currentPage) {
            let sort = this.sort.sortBy ? `&sort[${this.sort.sortBy}]=${this.sort.sortDesc ? 'desc' : 'asc'}` : '';

            axios
                .get('/api/advertisings?page=' + (currentPage || this.pagination.currentPage) + sort)
                .then(({data: {data, meta}}) => {
                    this.items = data
                    this.pagination.rows = meta.total;
                })
        },
        sortingChanged(ctx) {
            this.sort = ctx;
            this.getData();
        }
    }
}
</script>
