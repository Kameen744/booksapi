<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h1 class="mt-5 text-center">Books API</h1>
        <hr />
      </div>
      <div class="col-md-7 h-auto">
        <div class="card">
          <div class="card-header">
            <button
              type="button"
              class="btn btn-primary btn-sm"
              @click="newBook"
            >
              New Book
            </button>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
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
                      class="btn btn-primary btn-sm m-1"
                      @click="getBook(book.id)"
                    >
                      View
                    </button>

                    <button
                      type="button"
                      class="btn btn-success btn-sm m-1"
                      @click="editBook(book)"
                    >
                      Edit
                    </button>

                    <button
                      type="button"
                      class="btn btn-danger btn-sm m-1"
                      @click="deleteBook(book.id)"
                    >
                      Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- View book -->
      <div class="col-md-5" v-if="view === 'book'">
        <div class="card text-left">
          <div class="card-header">BooK - {{ viewBook.name }}</div>
          <div class="card-body">
            <P><span class="h4 text-bold">NAME:</span> {{ viewBook.name }}</P>
            <P><span class="h4 text-bold">ISBN:</span> {{ viewBook.isbn }}</P>
            <P
              ><span class="h4 text-bold">AUTHORS:</span>
              <span v-for="author in viewBook.authors" :key="author">
                {{ author }}</span
              >
            </P>
            <P
              ><span class="h4 text-bold">NUMBER OF PAGES:</span>
              {{ viewBook.number_of_pages }}</P
            >
            <P
              ><span class="h4 text-bold">PUBLISHER:</span>
              {{ viewBook.publisher }}</P
            >
            <P
              ><span class="h4 text-bold">COUNTRY:</span>
              {{ viewBook.country }}</P
            >
            <P
              ><span class="h4 text-bold">RELEASE DATE:</span>
              {{ viewBook.release_date }}</P
            >
          </div>
        </div>
      </div>
      <!-- create Book form -->
      <div class="col-md-5" v-if="view === 'newbook' || view === 'editbook'">
        <div class="card text-left">
          <div class="card-header">Add New Book</div>
          <div class="card-body">
            <div class="form-group">
              <input
                type="text"
                class="form-control mt-2"
                placeholder="Book Name"
                v-model="newBookForm.name"
              />
              <input
                type="text"
                class="form-control mt-2"
                placeholder="ISBN"
                v-model="newBookForm.isbn"
              />

              <input
                type="text"
                class="form-control mt-2"
                placeholder="Authors"
                v-model="newBookForm.authors"
              />
              <input
                type="text"
                class="form-control mt-2"
                placeholder="Country"
                v-model="newBookForm.country"
              />
              <input
                type="number"
                class="form-control mt-2"
                placeholder="Number of Pages"
                v-model="newBookForm.number_of_pages"
              />
              <input
                type="text"
                class="form-control mt-2"
                placeholder="Publisher"
                v-model="newBookForm.publisher"
              />
              <input
                type="date"
                class="form-control mt-2"
                placeholder="Release Date"
                v-model="newBookForm.release_date"
              />

              <hr />
              <button
                type="button"
                class="btn btn-primary btn-sm"
                @click="createBook"
                v-if="view === 'newbook'"
              >
                Create
              </button>
              <button
                type="button"
                class="btn btn-primary btn-sm"
                @click="updateBook"
                v-if="view === 'editbook'"
              >
                Update
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      books: [],
      view: "",
      viewBook: null,
      createdBook: null,
      newBookForm: {
        name: "",
        isbn: "",
        authors: "",
        country: "",
        number_of_pages: "",
        publisher: "",
        release_date: "",
      },
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
        this.view = "book";
      });
    },

    newBook() {
      this.view = "newbook";
    },

    createBook() {
      axios
        .post(`http://localhost:8080/api/v1/books`, this.newBookForm)
        .then((res) => {
          this.viewBook = res.data.data;
          this.getBooks();
          this.clearForm();
        });
    },

    editBook(book) {
      this.newBookForm.name = book.name;
      this.newBookForm.isbn = book.isbn;
      this.newBookForm.authors = book.authors[0];
      this.newBookForm.country = book.country;
      this.newBookForm.number_of_pages = book.number_of_pages;
      this.newBookForm.publisher = book.publisher;
      this.newBookForm.release_date = book.release_date;
      this.viewBook = book;
      this.view = "editbook";
    },

    updateBook() {
      let bookId = this.viewBook.id;
      axios
        .post(
          `http://localhost:8080/api/v1/books/${bookId}/update`,
          this.newBookForm
        )
        .then((res) => {
          this.getBooks();
          this.view = "";
        });
    },

    deleteBook(bookId) {
      axios
        .delete(
          `http://localhost:8080/api/v1/books/${bookId}`,
          this.newBookForm
        )
        .then((res) => {
          this.getBooks();
          this.view = "";
        });
    },

    clearForm() {
      this.newBookForm.name = "";
      this.newBookForm.isbn = "";
      this.newBookForm.authors = "";
      this.newBookForm.country = "";
      this.newBookForm.number_of_pages = "";
      this.newBookForm.publisher = "";
      this.newBookForm.release_date = "";
    },
  },
};
</script>
