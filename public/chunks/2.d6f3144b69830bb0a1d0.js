(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[2],{

/***/ "./Modules/SalesAgent/Resources/js/components/Agency/Form.vue":
/*!********************************************************************!*\
  !*** ./Modules/SalesAgent/Resources/js/components/Agency/Form.vue ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Form.vue?vue&type=script&lang=js& */ "./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");
var render, staticRenderFns




/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  render,
  staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "Modules/SalesAgent/Resources/js/components/Agency/Form.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************!*\
  !*** ./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./Form.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Form_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./Modules/SalesAgent/Resources/js/components/Agency/Form.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vee_validate__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vee-validate */ "./node_modules/vee-validate/dist/vee-validate.esm.js");
/* harmony import */ var vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vee-validate/dist/rules */ "./node_modules/vee-validate/dist/rules.js");
/* harmony import */ var vee_validate_dist_locale_id_json__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vee-validate/dist/locale/id.json */ "./node_modules/vee-validate/dist/locale/id.json");
var vee_validate_dist_locale_id_json__WEBPACK_IMPORTED_MODULE_2___namespace = /*#__PURE__*/__webpack_require__.t(/*! vee-validate/dist/locale/id.json */ "./node_modules/vee-validate/dist/locale/id.json", 1);



Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('required', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["required"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('email', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["email"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('max', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["max"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('numeric', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["numeric"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["extend"])('between', vee_validate_dist_rules__WEBPACK_IMPORTED_MODULE_1__["between"]);
Object(vee_validate__WEBPACK_IMPORTED_MODULE_0__["localize"])('id', vee_validate_dist_locale_id_json__WEBPACK_IMPORTED_MODULE_2__);
/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    ValidationObserver: vee_validate__WEBPACK_IMPORTED_MODULE_0__["ValidationObserver"],
    ValidationProvider: vee_validate__WEBPACK_IMPORTED_MODULE_0__["ValidationProvider"]
  },
  props: {
    uri: {
      type: String,
      required: true
    },
    redirectUri: {
      type: String,
      required: true
    },
    dataUri: {
      type: String,
      "default": ''
    }
  },
  data: function data() {
    return {
      field_state: false,
      formAlert: false,
      formAlertText: '',
      formAlertState: 'info',
      form_data: {
        agency_name: '',
        agency_email: '',
        agency_phone: '',
        agency_address: '',
        province: '',
        city: '',
        pph_final: ''
      }
    };
  },
  mounted: function mounted() {
    this.setData();
  },
  methods: {
    setData: function setData() {
      var _this = this;

      if (this.dataUri) {
        this.field_state = true;
        axios.get(this.dataUri).then(function (response) {
          if (response.data.success) {
            var data = response.data.data;
            _this.form_data = {
              agency_name: data.agency_name,
              agency_email: data.agency_email,
              agency_phone: data.agency_phone,
              agency_address: data.agency_address,
              province: data.province,
              city: data.city,
              pph_final: data.pph_final
            };
            _this.field_state = false;
          } else {
            _this.formAlert = true;
            _this.formAlertState = 'error';
            _this.formAlertText = response.data.message;
            _this.field_state = false;
          }
        })["catch"](function (error) {
          _this.tableAlert = true;
          _this.tableAlertState = 'error';
          _this.tableAlertText = 'Oops, something went wrong. Please try again later.';
          _this.field_state = false;
        });
      }
    },
    submit: function submit() {
      var _this2 = this;

      this.$refs.observer.validate().then(function (success) {
        if (!success) {
          return;
        }

        _this2.postFormData();
      });
    },
    clear: function clear() {
      this.form_data = {
        agency_name: '',
        agency_email: '',
        agency_phone: '',
        agency_address: '',
        province: '',
        city: '',
        pph_final: ''
      };
      this.$refs.observer.reset();
    },
    postFormData: function postFormData() {
      var _this3 = this;

      var data = new FormData(this.$refs['post-form']);

      if (this.dataUri) {
        data.append("_method", "put");
      }

      this.field_state = true;
      axios.post(this.uri, data).then(function (response) {
        if (response.data.success) {
          _this3.formAlert = true;
          _this3.formAlertState = 'success';
          _this3.formAlertText = response.data.message;
          setTimeout(function () {
            _this3["goto"](_this3.redirectUri);
          }, 6000);
        } else {
          _this3.formAlert = true;
          _this3.formAlertState = 'error';
          _this3.formAlertText = response.data.message;
          _this3.field_state = false;
        }
      })["catch"](function (error) {
        _this3.tableAlert = true;
        _this3.tableAlertState = 'error';
        _this3.tableAlertText = 'Oops, something went wrong. Please try again later.';
        _this3.field_state = false;
      });
    }
  }
});

/***/ })

}]);