<template>
  <div class="width_div_table">
    <v-toolbar flat color="white">
      <v-text-field
        color="indigo"
        v-model="search"
        append-icon="search"
        label="Pesquisar"
        single-line
        hide-details
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="500px">
        <v-btn slot="activator" color="indigo" dark class="mb-2">Cadastrar aluno</v-btn>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm12 md12>
                  <v-text-field color="indigo" v-model="editedItem.name" label="Nome"></v-text-field>
                </v-flex>
                <v-flex xs12 sm12 md12>
                  <v-text-field color="indigo" v-model="editedItem.cpf" label="CPF"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click.native="onClose">Cancelar</v-btn>
            <v-btn color="blue darken-1" flat @click.native="onSave">Salvar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="students"
      hide-actions
      class="elevation-1"
      :search="search"
    >
      <template slot="items" slot-scope="props">
        <td>{{ props.item.id }}</td>
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.cpf }}</td>
        <td class="justify-center align-center layout px-0">
          <v-icon
            small
            class="mr-2"
            color="indigo"
            @click="onEditItem(props.item)"
          >
            edit
          </v-icon>
          <v-icon
            small
            color="indigo"
            @click="onDeleteItem(props.item)"
          >
            delete
          </v-icon>
        </td>
      </template>
      <template slot="no-data">
        <v-btn color="indigo" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
    <div class="text-xs-center pt-2">
      <v-pagination color="indigo" v-model="pagination.page" :length="pages"></v-pagination>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  export default {
    data: () => ({
      apiRoute: process.env.VUE_APP_ROOT_API,
      dialog: false,
      search: '',
      pagination: {},
      headers: [
        { text: 'Reg. Acadêmico', value: 'id' },
        { text: 'Nome', value: 'name' },
        { text: 'CPF', value: 'cpf' },
      ],
      students: [],
      editedIndex: -1,
      editedItem: {
        id: 0,
        name: '',
        cpf: '',
      },
      defaultItem: {
        id: 0,
        name: '',
        cpf: '',
      }
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Novo aluno' : 'Editar aluno'
      },
       pages () {
        if (this.pagination.rowsPerPage == null ||
          this.pagination.totalItems == null
        ) return 0

        return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage)
      }
    },

    watch: {
      dialog (val) {
        val || this.onClose()
      }
    },

    async created () {
      await this.initialize()
    },

    methods: {
      async initialize() {
        /*
        * @TODO
        * I'd implement toast notification, would look better!
        */
        await axios.get(
          `${this.apiRoute}/student`
        ).then(res => this.students = res.data.data)
        .catch(() => {
          this.students = [];
        })
      },

      async onEditItem (item) {
        this.editedIndex = this.students.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      async onDeleteItem (item) {
        this.editedIndex = this.students.indexOf(item)
        this.editedItem = Object.assign({}, item)
        if(confirm('Você tem certeza que deseja remover esse aluno?')) {
          await axios.delete(
            `${this.apiRoute}/student/${this.editedItem.id}`
          ).then(async (res) => {
            if (res.status === 204) {
              await this.initialize()
            }
            /*
             * @TODO
             * I'd implement toast notification, would look better!
             */
          }).catch(() => alert('Ops, algo deu errado...'))
        }
      },

      async onClose () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
      },

      async onSave () {
        const payload = {
          name: this.editedItem.name,
          cpf: this.editedItem.cpf,
        };

        const errorMessage = 'Ops, algo deu errado, verique os campos e tente novamente...';

        if(this.editedItem.id !== 0)
          await axios.put(
            `${this.apiRoute}/student/${this.editedItem.id}`,
            payload
          ).then(async (res) => {
            if (res.status === 200) {
              await this.initialize()
              this.onClose()
            }
            /*
             * @TODO
             * I'd implement toast notification, would look better!
             */
          }).catch(() => alert(errorMessage))

        else
          await axios.post(
            `${this.apiRoute}/student`,
            payload
          ).then(async (res) => {
            if (res.status === 200) {
              await this.initialize()
              this.onClose()
            }
            /*
             * @TODO
             * I'd implement toast notification, would look better!
             */
          }).catch(() => alert(errorMessage))
      }
    }
  }
</script>

<style type="text/css">
  .width_div_table{
     width: 1000px;
  }
</style>