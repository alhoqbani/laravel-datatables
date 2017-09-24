<template>
    <div class="panel panel-default">
        <div class="panel-heading">Table Name</div>

        <div class="panel-body">
            Table
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'data-table',
        props: ['endpoint'],
        data () {
            return {
                response: {
                    table: '',
                    displayableColumns: [],
                    records: [],
                }
            }
        },
        mounted() {
            axios.get(`${this.endpoint}`).then(response => this.response = response);
        }
    }
</script>
