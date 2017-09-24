<template>
    <div class="panel panel-default">
        <div class="panel-heading">{{response.table.toUpperCase()}}</div>

        <div class="panel-body">

            <div class="row">
                <div class="form-group col-md-10">
                    <label for="filter">Quick search current results</label>
                    <input type="text" id="filter" class="form-control" v-model="quickSearchQuery">
                </div>
                <div class="form-group col-md-2">
                    <label for="limit">Display records</label>
                    <select id="limit" class="form-control" v-model="limit" @change="getRecords">
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="1000">1000</option>
                        <option value="">All</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th v-for="column in response.displayableColumns">
                            <div class="sortable" @click="sortBy(column)">{{ column }}
                                <div
                                    class="arrow"
                                    v-if="sort.key === column"
                                    :class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc' }"
                                ></div>
                            </div>
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="record in filteredRecords">
                        <td v-for="value, proprty in record">
                            <template v-if="editing.id == record.id && isUpdatable(proprty)">
                                <input type="text"
                                       class="form-control"
                                       v-model="editing.form[proprty]">
                            </template>
                            <template v-else>
                                {{value}}
                            </template>
                        </td>
                        <td>
                            <a href="#" @click.prevent="edit(record)" v-if="editing.id !== record.id">Edit</a>

                            <template v-if="editing.id === record.id">
                                <a href="#" @click.prevent="update">Save</a><br>
                                <a href="#" @click.prevent="editing.id = null">Cancel</a>
                            </template>
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
    import queryString from 'query-string';

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
                },
                quickSearchQuery: '',
                limit: 50,
                editing: {
                    id: null,
                    form: {},
                    errors: []
                }
            }
        },
        computed: {
            filteredRecords() {
                let data = this.response.records;

                data = data.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.quickSearchQuery.toLowerCase()) > -1
                    })
                })

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
            getRecords() {
                axios.get(`${this.endpoint}?${this.getQueryParameters()}`).then(response => this.response = response.data);
            },
            getQueryParameters() {
                return queryString.stringify({
                    limit: this.limit,
                })
            },
            sortBy(column) {
                this.sort.key = column;
                this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc';
            },
            edit(record) {
                this.editing.errors = []
                this.editing.id = record.id
                this.editing.form = _.pick(record, this.response.updatable)
            },
            update() {

            },
            isUpdatable(proprty) {
                return this.response.updatable.includes(proprty)
            },
        },
        mounted() {
            this.getRecords();
        }
    }
</script>


<style lang="scss">
    .sortable {
        cursor: pointer;
    }

    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: .6;

        &--asc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 4px solid #222;
        }

        &--desc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid #222;
        }
    }
</style>
