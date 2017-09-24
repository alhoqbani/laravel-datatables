<template>
    <div class="panel panel-default">
        <div class="panel-heading">{{response.table.toUpperCase()}}</div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th v-for="column in response.displayableColumns">
                            <span @click="sortBy(column)">{{ column }}</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="record in filteredRecords">
                        <td v-for="value, proprty in record">
                            {{value}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import * as _ from "lodash";

    export default {
        name: 'data-table',
        props: ['endpoint'],
        data() {
            return {
                response: {
                    table: '',
                    displayableColumns: [],
                    records: [],
                },
                sort: {
                    key: 'id',
                    order: 'asc'
                }
            }
        },
        computed: {
            filteredRecords() {
                let data = this.response.records;

                if (this.sort.key) {
                    data = _.orderBy(data, (i) => {
                        let value = i[this.sort.key]

                        if (!isNaN(parseFloat(value))) {
                            return parseFloat(value);
                        }
                        return String(value).toLowerCase()
                    }, this.sort.order)
                }

                return data
            }
        },
        methods: {
            sortBy(column) {
                this.sort.key = column;
                this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc';
            }
        },
        mounted() {
            axios.get(`${this.endpoint}`).then(response => this.response = response.data);
        }
    }
</script>
