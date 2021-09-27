<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h1>Books API</h1>
        <hr />
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">-Books-</div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>S/No</th>
                  <th>Name</th>
                  <th>ISBN</th>
                  <th>Authors</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(book, index) in books" :key="index">
                  <td scope="row">{{ index }}</td>
                  <td>{{ book.name }}</td>
                  <td>{{ book.isbn }}</td>
                  <td>
                    <span v-for="author in book.authors" :key="author">{{
                      author
                    }}</span>
                  </td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-primary btn-sm"
                      @click="getBook(book.id)"
                    >
                      View
                    </button>
                    |
                    <button type="button" class="btn btn-success btn-sm">
                      Update
                    </button>
                    |
                    <button type="button" class="btn btn-danger btn-sm">
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4" v-if="viewBook">
        <div class="card text-left">
          <div class="card-header">{{ viewBook.name }}</div>
          <div class="card-body"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      test: "test data",
      books: [],
      viewBook: null,
    };
  },
  mounted() {
    this.getBooks();
  },

  methods: {
    getBooks() {
      axios.get(`http://localhost:8080/api/v1/books/`).then((res) => {
        this.books = res.data.data;
      });
    },

    getBook(id) {
      axios.get(`http://localhost:8080/api/v1/books/${id}`).then((res) => {
        this.viewBook = res.data.data;
        console.log(this.viewBook);
      });
    },
  },
};
</script>
