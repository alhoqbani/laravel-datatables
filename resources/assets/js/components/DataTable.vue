<template>
    <div class="panel panel-default">
        <div class="panel-heading">{{response.table.toUpperCase()}}</div>

        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th v-for="column in response.displayableColumns">{{ column }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="record in response.records">
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

    export default {
        name: 'data-table',
        props: ['endpoint'],
        data() {
            return {
                response: {
                    table: '',
                    displayableColumns: [],
                    records: [],
                }
            }
        },
        mounted() {
            axios.get(`${this.endpoint}`).then(response => this.response = response.data);
        }
    }
</script>
