(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[1],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Table.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Table.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var call;
/* harmony default export */ __webpack_exports__["default"] = ({
  props: {
    uri: {
      type: String,
      required: true
    },
    headers: {
      type: Array,
      required: true
    },
    noDataText: {
      type: String,
      "default": "No data found."
    },
    noResultsText: {
      type: String,
      "default": "No data found."
    },
    searchText: {
      type: String,
      "default": "Search"
    },
    searchIcon: {
      type: String,
      "default": "mdi-magnify"
    },
    refreshText: {
      type: String,
      "default": "Reload"
    },
    refreshIcon: {
      type: String,
      "default": "mdi-sync"
    },
    addNewText: {
      type: String,
      "default": "Add New"
    },
    addNewIcon: {
      type: String,
      "default": "mdi-plus"
    },
    addNewUri: {
      type: String,
      "default": ""
    },
    addNewColor: {
      type: String,
      "default": "info"
    },
    itemsPerPageAllText: {
      type: String,
      "default": "All"
    },
    itemsPerPageText: {
      type: String,
      "default": "Rows per page:"
    },
    pageTextLocale: {
      type: String,
      "default": "en"
    },
    editUri: {
      type: String,
      "default": ""
    },
    editUriParameter: {
      type: String,
      "default": ""
    },
    editText: {
      type: String,
      "default": "Edit"
    },
    editIcon: {
      type: String,
      "default": "mdi-pencil"
    },
    editColor: {
      type: String,
      "default": "primary"
    },
    deleteUri: {
      type: String,
      "default": ""
    },
    deleteUriParameter: {
      type: String,
      "default": ""
    },
    deleteText: {
      type: String,
      "default": "Delete"
    },
    deleteIcon: {
      type: String,
      "default": "mdi-trash-can-outline"
    },
    deleteColor: {
      type: String,
      "default": "red lighten-1"
    },
    deleteConfirmationText: {
      type: String,
      "default": "Are you sure want to delete this data ?"
    },
    deleteCancelText: {
      type: String,
      "default": "Cancel"
    }
  },
  data: function data() {
    return {
      promptDelete: false,
      search: '',
      totalData: 0,
      fromData: 0,
      toData: 0,
      tableItems: [],
      loading: true,
      options: {},
      tableSortBy: [],
      tableSortDesc: [],
      selected: null,
      deleteLoader: false,
      tableAlert: false,
      tableAlertText: '',
      tableAlertState: 'info'
    };
  },
  watch: {
    options: {
      handler: function handler() {
        this.dataHandler();
      },
      deep: true
    }
  },
  mounted: function mounted() {
    this.dataHandler();
  },
  computed: {
    query: function query() {
      var _this = this;

      var sortBy = [];

      _.forEach(this.options.sortBy, function (value, key) {
        sortBy.push({
          0: value,
          1: _this.options.sortDesc[key]
        });
      });

      return '?page=' + this.options.page + '&search=' + this.search + '&paginate=' + this.options.itemsPerPage + '&sort=' + JSON.stringify(sortBy);
    }
  },
  methods: {
    dataHandler: function dataHandler() {
      setTimeout(this.getData(), 2000);
    },
    getData: function getData() {
      var _this2 = this;

      this.loading = true;

      if (call) {
        call.cancel();
      }

      call = axios.CancelToken.source();
      axios.get(this.uri + this.query, {
        cancelToken: call.token
      }).then(function (response) {
        _this2.tableItems = response.data.data.data;
        _this2.totalData = response.data.data.total;
        _this2.fromData = response.data.data.from;
        _this2.toData = response.data.data.to;
        _this2.loading = false;
      })["catch"](function (error) {
        _this2.loading = false;
      });
    },
    promptDeleteItem: function promptDeleteItem(item) {
      this.promptDelete = true;
      this.selected = item;
    },
    deleteItem: function deleteItem() {
      var _this3 = this;

      this.deleteLoader = true;
      axios["delete"](this.base_url() + this.ziggy(this.deleteUri, [this.selected[this.deleteUriParameter]]).url()).then(function (response) {
        if (response.data.success) {
          _this3.tableAlert = true;
          _this3.tableAlertState = 'success';
          _this3.tableAlertText = response.data.message;

          _this3.dataHandler();
        } else {
          _this3.tableAlert = true;
          _this3.tableAlertState = 'error';
          _this3.tableAlertText = response.data.message;
        }

        _this3.deleteLoader = false;
        _this3.promptDelete = false;
      })["catch"](function (error) {
        _this3.tableAlert = true;
        _this3.tableAlertState = 'error';
        _this3.tableAlertText = 'Oops, something went wrong. Please try again later.';
        _this3.deleteLoader = false;
        _this3.promptDelete = false;
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/components/Table.vue":
/*!*******************************************!*\
  !*** ./resources/js/components/Table.vue ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Table.vue?vue&type=script&lang=js& */ "./resources/js/components/Table.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns




/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _Table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Table.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Table.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/components/Table.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Table.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Table.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Table_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ })

}]);