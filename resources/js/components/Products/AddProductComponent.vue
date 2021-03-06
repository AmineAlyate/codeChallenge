<template>
  <div>
    <div
      v-if="showModal"
      class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
    >
      <div class="relative w-auto my-6 mx-auto max-w-3xl">
        <!--content-->
        <div
          class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none"
        >
          <!--header-->
          <div
            class="flex items-start justify-center p-2 border-b border-solid border-gray-300 rounded-t"
          >
            <h3 class="text-xl font-semibold">Add Product</h3>
          </div>
          <!--body-->
          <div class="relative p-4 w-80">
            <div class="w-full flex justify-center">
              <div
                class="bg-white border-2 border-gray-200 cursor-pointer h-48 w-40 flex items-center justify-center"
                @click="showFileInput"
                v-if="!url"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  fill="#cccc"
                  width="100%"
                  height="100%"
                >
                  <path d="M0 0h24v24H0z" fill="none" />
                  <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
              </div>
              <div
                class="bg-white border-2 border-gray-200 cursor-pointer h-48 w-40 flex items-center justify-center relative"
                v-if="url"
              >
                <div class="absolute left-0 top-0" @click="clearSelectedImage()">
                  <svg
                    class="h-6 w-6 text-white bg-red-300 cursor-pointer hover:bg-red-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </div>
                <img class="w-full h-full" :src="url" />
              </div>
            </div>
            <input hidden type="file" ref="file" @change="changed" accept="image/*" />
            <div class="my-2">
              <input
                class="bg-white py-2 px-4 w-full border-2 border-gray-200 focus:outline-none focus:border-green-200"
                placeholder="Name"
                v-model="product.name"
              />
            </div>
            <div class="mb-2">
              <textarea
                class="bg-white py-2 px-4 w-full border-2 border-gray-200 focus:outline-none focus:border-green-200"
                placeholder="Description"
                v-model="product.description"
              ></textarea>
            </div>
            <div class="mb-2">
              <input
                class="bg-white py-2 px-4 w-full border-2 border-gray-200 focus:outline-none focus:border-green-200"
                placeholder="Price"
                type="number"
                v-model="product.price"
              />
            </div>
            <div class="mb-2">
              <select
                class="bg-white py-2 px-4 w-full border-2 border-gray-200 focus:outline-none focus:border-green-200"
                @change="categorieChanged"
                v-model="selectedCategorie"
              >
                <option value="null" class="text-gray-300" disabled>Categories</option>
                <option :value="c" :key="c.id" v-for="c in cats">
                  {{ c.name }}
                </option>
              </select>
            </div>
            <div>
              <span
                v-for="(cat, key) in product.categories"
                :key="cat.id"
                @click="removeCat(key)"
                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 ml-1 relative hover:text-red-800 hover:bg-red-100 cursor-pointer"
              >
                <span>{{ cat.name }}</span>
              </span>
            </div>
          </div>
          <!--footer-->
          <div
            class="flex items-center justify-end p-2 border-t border-solid border-gray-300 rounded-b"
          >
            <button
              class="text-green-500 bg-transparent border border-solid border-green-500 hover:bg-green-500 hover:text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1"
              type="button"
              style="transition: all 0.15s ease"
              v-on:click="addProduct()"
              :disabled="disabled"
            >
              Add
            </button>
            <button
              class="text-green-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1"
              type="button"
              style="transition: all 0.15s ease"
              v-on:click="toggelModal()"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
  </div>
</template>

<script>
import Axios from "axios";
export default {
  props: ["showModal", "cats"],
  data() {
    return {
      url: "",
      product: this.freshProduct(),
      selectedCategorie: null,
      disabled: false,
    };
  },
  mounted() {},
  methods: {
    toggelModal: function () {
      this.$emit("toggelModal");
    },
    addProduct() {
      this.disabled = true;
      var data = {
        product: Object.assign({}, this.product),
        categories: this.product.categories.map((a) => a.id),
      };
      data.product.categories = "";
      Axios.post("/api/addProduct", data)
        .then((res) => {
          this.$emit("addSuccess", res.data);
          this.product = this.freshProduct();
          this.url = "";
          this.selectedCategorie = null;
        })
        .catch(() => {
          alert("the given data is invalid");
        })
        .finally((err) => {
          this.disabled = false;
        });
    },
    showFileInput() {
      this.$refs["file"].click();
    },
    changed(e) {
      const file = e.target.files[0];
      let url = URL.createObjectURL(file);
      let reader = new FileReader();
      reader.onloadend = () => (this.product.image = reader.result);
      reader.readAsDataURL(file);
      this.url = url;
    },
    categorieChanged() {
      //if the categorie not already checked
      if (this.product.categories.indexOf(this.selectedCategorie) < 0)
        this.product.categories.push(this.selectedCategorie);
    },
    freshProduct() {
      return {
        name: "",
        description: "",
        price: "",
        image: "",
        categories: [],
      };
    },
    removeCat(key) {
      this.product.categories.splice(key, 1);
    },
    clearSelectedImage() {
      this.url = "";
      this.product.image = "";
    },
  },
};
</script>
