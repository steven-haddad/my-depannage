webpackJsonp([1],{

/***/ "./node_modules/css-loader/index.js?{\"importLoaders\":1}!./node_modules/postcss-loader/lib/index.js?{\"ident\":\"postcss\",\"plugins\":[null,null]}!./src/components/GraphicModules/Background/AppBackground/styles/AppBackground.css":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader?{"importLoaders":1}!./node_modules/postcss-loader/lib?{"ident":"postcss","plugins":[null,null]}!./src/components/GraphicModules/Background/AppBackground/styles/AppBackground.css ***!
  \*******************************************************************************************************************************************************************************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(undefined);
// imports


// module
exports.push([module.i, "#bg {\n  position: fixed;\n  top: -50%;\n  left: -50%;\n  width: 200%;\n  height: 200%;\n}\n\n#bg div {\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  margin: auto;\n  min-width: 50%;\n  min-height: 50%;\n  background: #EDF0F2;\n}", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js?{\"importLoaders\":1}!./node_modules/postcss-loader/lib/index.js?{\"ident\":\"postcss\",\"plugins\":[null,null]}!./src/components/UIComponents/Bar/SideBar/styles/SideBar.css":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader?{"importLoaders":1}!./node_modules/postcss-loader/lib?{"ident":"postcss","plugins":[null,null]}!./src/components/UIComponents/Bar/SideBar/styles/SideBar.css ***!
  \**********************************************************************************************************************************************************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(undefined);
// imports


// module
exports.push([module.i, "#sidebarItem {\n    height: 65px;\n    border-radius: 0px;\n    border-bottom:1px solid grey;\n    color: white;\n    font-size:18px;\n    padding-top:10px; \n    text-align: left;\n}\n\n#sidebarItem img{\n    width: 35px;\n    height: 35px;\n    margin-left: -8px;\n    margin-right: 15px;\n}\n\n#sidebarItem:hover{\n    color: #048;\n    background-color: #C6DEFF;\n}\n\n#sidebar-wrapper {\n    z-index: 1000;\n    position: fixed; \n    top:47px;\n    left: 210px;\n    width: 0;\n    height: 100%;\n    margin-left: -210px;\n    overflow-y: auto;\n    /*background-color: #C6DEFF;*/\n    /* background-color:black; */\n    background-color:#2C3539;\n    -webkit-transition: all 0.5s ease;\n    -o-transition: all 0.5s ease;\n    transition: all 0.5s ease;\n}\n\n.sidebar-nav {\n    position: absolute;\n    top: 0;\n    width: 210px;\n    margin: 0;\n    padding: 0;\n    list-style: none;\n    margin-top: 2px;\n}\n\n.sidebar-nav li {\n    text-indent: 15px;\n    line-height: 40px;\n}\n\n.sidebar-nav li a {\n    display: block;\n    text-decoration: none;\n    color: #999999;\n}\n\n.sidebar-close #sidebar-wrapper {\n    width: 50px;\n}\n\n.sidebar-open #sidebar-wrapper {\n    width: 210px;\n}\n\n", ""]);

// exports


/***/ }),

/***/ "./src/components/GraphicModules/Background/AppBackground/AppBackground.jsx":
/*!**********************************************************************************!*\
  !*** ./src/components/GraphicModules/Background/AppBackground/AppBackground.jsx ***!
  \**********************************************************************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__styles_AppBackground_css__ = __webpack_require__(/*! ./styles/AppBackground.css */ "./src/components/GraphicModules/Background/AppBackground/styles/AppBackground.css");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__styles_AppBackground_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__styles_AppBackground_css__);
var _jsxFileName = '/Users/alexiszrihen/Desktop/three_modules/triazur/src/components/GraphicModules/Background/AppBackground/AppBackground.jsx',
    _this = this;




var AppBackground = function AppBackground() {
  return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
    'div',
    { id: 'bg', __source: {
        fileName: _jsxFileName,
        lineNumber: 5
      },
      __self: _this
    },
    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('div', { className: 'back', __source: {
        fileName: _jsxFileName,
        lineNumber: 6
      },
      __self: _this
    })
  );
};

/* harmony default export */ __webpack_exports__["a"] = (AppBackground);

/***/ }),

/***/ "./src/components/GraphicModules/Background/AppBackground/styles/AppBackground.css":
/*!*****************************************************************************************!*\
  !*** ./src/components/GraphicModules/Background/AppBackground/styles/AppBackground.css ***!
  \*****************************************************************************************/
/*! dynamic exports provided */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader??ref--1-oneOf-3-1!../../../../../../node_modules/postcss-loader/lib??postcss!./AppBackground.css */ "./node_modules/css-loader/index.js?{\"importLoaders\":1}!./node_modules/postcss-loader/lib/index.js?{\"ident\":\"postcss\",\"plugins\":[null,null]}!./src/components/GraphicModules/Background/AppBackground/styles/AppBackground.css");
if(typeof content === 'string') content = [[module.i, content, '']];
// Prepare cssTransformation
var transform;

var options = {"hmr":true}
options.transform = transform
// add the styles to the DOM
var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(true) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept(/*! !../../../../../../node_modules/css-loader??ref--1-oneOf-3-1!../../../../../../node_modules/postcss-loader/lib??postcss!./AppBackground.css */ "./node_modules/css-loader/index.js?{\"importLoaders\":1}!./node_modules/postcss-loader/lib/index.js?{\"ident\":\"postcss\",\"plugins\":[null,null]}!./src/components/GraphicModules/Background/AppBackground/styles/AppBackground.css", function() {
			var newContent = __webpack_require__(/*! !../../../../../../node_modules/css-loader??ref--1-oneOf-3-1!../../../../../../node_modules/postcss-loader/lib??postcss!./AppBackground.css */ "./node_modules/css-loader/index.js?{\"importLoaders\":1}!./node_modules/postcss-loader/lib/index.js?{\"ident\":\"postcss\",\"plugins\":[null,null]}!./src/components/GraphicModules/Background/AppBackground/styles/AppBackground.css");
			if(typeof newContent === 'string') newContent = [[module.i, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./src/components/UIComponents/Bar/NavBarApp/NavBarApp.jsx":
/*!*****************************************************************!*\
  !*** ./src/components/UIComponents/Bar/NavBarApp/NavBarApp.jsx ***!
  \*****************************************************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_reactstrap__ = __webpack_require__(/*! reactstrap */ "./node_modules/reactstrap/dist/reactstrap.es.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_react_router_dom__ = __webpack_require__(/*! react-router-dom */ "./node_modules/react-router-dom/es/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_react_redux__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__img_TriAzurIcon_png__ = __webpack_require__(/*! ./img/TriAzurIcon.png */ "./src/components/UIComponents/Bar/NavBarApp/img/TriAzurIcon.png");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__img_TriAzurIcon_png___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5__img_TriAzurIcon_png__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__img_fr_svg__ = __webpack_require__(/*! ./img/fr.svg */ "./src/components/UIComponents/Bar/NavBarApp/img/fr.svg");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__img_fr_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6__img_fr_svg__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__img_gb_svg__ = __webpack_require__(/*! ./img/gb.svg */ "./src/components/UIComponents/Bar/NavBarApp/img/gb.svg");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__img_gb_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_7__img_gb_svg__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__actions__ = __webpack_require__(/*! ./actions */ "./src/components/UIComponents/Bar/NavBarApp/actions.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__Field_DropDownApp__ = __webpack_require__(/*! ../../Field/DropDownApp */ "./src/components/UIComponents/Field/DropDownApp/DropDownApp.jsx");
var _jsxFileName = '/Users/alexiszrihen/Desktop/three_modules/triazur/src/components/UIComponents/Bar/NavBarApp/NavBarApp.jsx';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }














var NavBarApp = function (_React$Component) {
  _inherits(NavBarApp, _React$Component);

  function NavBarApp(props) {
    _classCallCheck(this, NavBarApp);

    var _this = _possibleConstructorReturn(this, (NavBarApp.__proto__ || Object.getPrototypeOf(NavBarApp)).call(this, props));

    _this.toggle = _this.toggle.bind(_this);
    _this.toggleSideBar = _this.toggleSideBar.bind(_this);
    _this.changeLanguageValue = _this.changeLanguageValue.bind(_this);
    _this.state = {
      isOpen: false,
      dropDownLanguageValue: 'En'
    };
    return _this;
  }

  _createClass(NavBarApp, [{
    key: 'changeLanguageValue',
    value: function changeLanguageValue(e) {
      this.setState({ dropDownLanguageValue: e.currentTarget.textContent });
    }
  }, {
    key: 'toggle',
    value: function toggle() {
      this.setState({
        isOpen: !this.state.isOpen
      });
    }
  }, {
    key: 'toggleSideBar',
    value: function toggleSideBar() {
      this.props.controlSideBar(this.props.isOpenSideBar);
    }
  }, {
    key: 'render',
    value: function render() {
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'div',
        {
          __source: {
            fileName: _jsxFileName,
            lineNumber: 58
          },
          __self: this
        },
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          __WEBPACK_IMPORTED_MODULE_2_reactstrap__["C" /* Navbar */],
          { className: 'navbarapp', dark: true, color: 'light', expand: 'md', fixed: 'top', __source: {
              fileName: _jsxFileName,
              lineNumber: 59
            },
            __self: this
          },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            'a',
            { onClick: this.toggleSideBar, className: 'navbar-brand', href: '#menu-toggle', id: 'menu-toggle', __source: {
                fileName: _jsxFileName,
                lineNumber: 60
              },
              __self: this
            },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              'i',
              { className: 'material-icons d-inline-block', __source: {
                  fileName: _jsxFileName,
                  lineNumber: 61
                },
                __self: this
              },
              'reorder'
            )
          ),
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            __WEBPACK_IMPORTED_MODULE_2_reactstrap__["D" /* NavbarBrand */],
            {
              id: 'navbarTitle1',
              href: '/',
              style: { backgroundImage: 'url(' + __WEBPACK_IMPORTED_MODULE_5__img_TriAzurIcon_png___default.a + ')' },
              __source: {
                fileName: _jsxFileName,
                lineNumber: 66
              },
              __self: this
            },
            this.props.apptitle
          ),
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            __WEBPACK_IMPORTED_MODULE_2_reactstrap__["E" /* NavbarToggler */],
            { onClick: this.toggle, style: { color: 'white' }, __source: {
                fileName: _jsxFileName,
                lineNumber: 73
              },
              __self: this
            },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('span', { className: 'navbar-toggler-icon', __source: {
                fileName: _jsxFileName,
                lineNumber: 74
              },
              __self: this
            })
          ),
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            __WEBPACK_IMPORTED_MODULE_2_reactstrap__["m" /* Collapse */],
            { isOpen: this.state.isOpen, navbar: true, __source: {
                fileName: _jsxFileName,
                lineNumber: 76
              },
              __self: this
            },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              __WEBPACK_IMPORTED_MODULE_2_reactstrap__["z" /* Nav */],
              { className: 'ml-auto', navbar: true, __source: {
                  fileName: _jsxFileName,
                  lineNumber: 77
                },
                __self: this
              },
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                __WEBPACK_IMPORTED_MODULE_2_reactstrap__["K" /* UncontrolledDropdown */],
                { nav: true, inNavbar: true, __source: {
                    fileName: _jsxFileName,
                    lineNumber: 78
                  },
                  __self: this
                },
                __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                  __WEBPACK_IMPORTED_MODULE_2_reactstrap__["r" /* DropdownToggle */],
                  { nav: true, caret: true, id: 'navbarTitle3', __source: {
                      fileName: _jsxFileName,
                      lineNumber: 79
                    },
                    __self: this
                  },
                  this.state.dropDownLanguageValue
                ),
                __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                  __WEBPACK_IMPORTED_MODULE_2_reactstrap__["q" /* DropdownMenu */],
                  { right: true, className: 'languagedropdownmenu', __source: {
                      fileName: _jsxFileName,
                      lineNumber: 82
                    },
                    __self: this
                  },
                  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                    __WEBPACK_IMPORTED_MODULE_2_reactstrap__["p" /* DropdownItem */],
                    { className: 'languagedropdownitem', __source: {
                        fileName: _jsxFileName,
                        lineNumber: 83
                      },
                      __self: this
                    },
                    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                      __WEBPACK_IMPORTED_MODULE_2_reactstrap__["s" /* FormGroup */],
                      { row: true, onClick: this.changeLanguageValue, __source: {
                          fileName: _jsxFileName,
                          lineNumber: 84
                        },
                        __self: this
                      },
                      __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                        __WEBPACK_IMPORTED_MODULE_2_reactstrap__["l" /* Col */],
                        { sm: 4, style: { maxWidth: '40px' }, __source: {
                            fileName: _jsxFileName,
                            lineNumber: 85
                          },
                          __self: this
                        },
                        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('img', { src: __WEBPACK_IMPORTED_MODULE_6__img_fr_svg___default.a, alt: 'frIcon', width: '25', height: '25', __source: {
                            fileName: _jsxFileName,
                            lineNumber: 86
                          },
                          __self: this
                        })
                      ),
                      __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                        __WEBPACK_IMPORTED_MODULE_2_reactstrap__["x" /* Label */],
                        { sm: 8, __source: {
                            fileName: _jsxFileName,
                            lineNumber: 88
                          },
                          __self: this
                        },
                        'Fr'
                      )
                    )
                  ),
                  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                    __WEBPACK_IMPORTED_MODULE_2_reactstrap__["p" /* DropdownItem */],
                    { className: 'languagedropdownitem', __source: {
                        fileName: _jsxFileName,
                        lineNumber: 91
                      },
                      __self: this
                    },
                    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                      __WEBPACK_IMPORTED_MODULE_2_reactstrap__["s" /* FormGroup */],
                      { row: true, onClick: this.changeLanguageValue, __source: {
                          fileName: _jsxFileName,
                          lineNumber: 92
                        },
                        __self: this
                      },
                      __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                        __WEBPACK_IMPORTED_MODULE_2_reactstrap__["l" /* Col */],
                        { sm: 4, style: { maxWidth: '40px' }, __source: {
                            fileName: _jsxFileName,
                            lineNumber: 93
                          },
                          __self: this
                        },
                        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('img', { src: __WEBPACK_IMPORTED_MODULE_7__img_gb_svg___default.a, alt: 'gbIcon', width: '25', height: '25', __source: {
                            fileName: _jsxFileName,
                            lineNumber: 94
                          },
                          __self: this
                        })
                      ),
                      __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                        __WEBPACK_IMPORTED_MODULE_2_reactstrap__["x" /* Label */],
                        { sm: 8, __source: {
                            fileName: _jsxFileName,
                            lineNumber: 96
                          },
                          __self: this
                        },
                        'En'
                      )
                    )
                  )
                )
              ),
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                __WEBPACK_IMPORTED_MODULE_2_reactstrap__["A" /* NavItem */],
                {
                  __source: {
                    fileName: _jsxFileName,
                    lineNumber: 104
                  },
                  __self: this
                },
                __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                  __WEBPACK_IMPORTED_MODULE_3_react_router_dom__["a" /* Link */],
                  { className: 'nav-link', to: '/dashboard', id: 'navbarTitle3', __source: {
                      fileName: _jsxFileName,
                      lineNumber: 105
                    },
                    __self: this
                  },
                  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                    'i',
                    { className: 'material-icons d-inline-block', __source: {
                        fileName: _jsxFileName,
                        lineNumber: 106
                      },
                      __self: this
                    },
                    'dashboard'
                  ),
                  'Dashboard'
                )
              ),
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                __WEBPACK_IMPORTED_MODULE_2_reactstrap__["A" /* NavItem */],
                {
                  __source: {
                    fileName: _jsxFileName,
                    lineNumber: 110
                  },
                  __self: this
                },
                __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                  __WEBPACK_IMPORTED_MODULE_3_react_router_dom__["a" /* Link */],
                  { className: 'nav-link', to: '/dashboard/applications', id: 'navbarTitle3', __source: {
                      fileName: _jsxFileName,
                      lineNumber: 111
                    },
                    __self: this
                  },
                  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                    'i',
                    { className: 'material-icons d-inline-block', __source: {
                        fileName: _jsxFileName,
                        lineNumber: 112
                      },
                      __self: this
                    },
                    'apps'
                  ),
                  'Applications'
                )
              ),
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                __WEBPACK_IMPORTED_MODULE_2_reactstrap__["K" /* UncontrolledDropdown */],
                { nav: true, inNavbar: true, __source: {
                    fileName: _jsxFileName,
                    lineNumber: 116
                  },
                  __self: this
                },
                __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                  __WEBPACK_IMPORTED_MODULE_2_reactstrap__["r" /* DropdownToggle */],
                  { nav: true, caret: true, id: 'navbarTitle3', __source: {
                      fileName: _jsxFileName,
                      lineNumber: 117
                    },
                    __self: this
                  },
                  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                    'i',
                    { className: 'material-icons d-inline-block', __source: {
                        fileName: _jsxFileName,
                        lineNumber: 118
                      },
                      __self: this
                    },
                    'perm_identity'
                  ),
                  'UserName'
                ),
                __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                  __WEBPACK_IMPORTED_MODULE_2_reactstrap__["q" /* DropdownMenu */],
                  { className: 'dropdownmenu', right: true, __source: {
                      fileName: _jsxFileName,
                      lineNumber: 123
                    },
                    __self: this
                  },
                  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                    __WEBPACK_IMPORTED_MODULE_2_reactstrap__["p" /* DropdownItem */],
                    { className: 'dropdownitem', __source: {
                        fileName: _jsxFileName,
                        lineNumber: 124
                      },
                      __self: this
                    },
                    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                      'i',
                      { className: 'material-icons d-inline-block align-top', __source: {
                          fileName: _jsxFileName,
                          lineNumber: 125
                        },
                        __self: this
                      },
                      'account_circle'
                    ),
                    'Account'
                  ),
                  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                    __WEBPACK_IMPORTED_MODULE_2_reactstrap__["p" /* DropdownItem */],
                    { className: 'dropdownitem', __source: {
                        fileName: _jsxFileName,
                        lineNumber: 130
                      },
                      __self: this
                    },
                    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                      'i',
                      { className: 'material-icons d-inline-block align-top', __source: {
                          fileName: _jsxFileName,
                          lineNumber: 131
                        },
                        __self: this
                      },
                      'settings'
                    ),
                    'Settings'
                  ),
                  __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                    __WEBPACK_IMPORTED_MODULE_2_reactstrap__["p" /* DropdownItem */],
                    { className: 'dropdownitem', __source: {
                        fileName: _jsxFileName,
                        lineNumber: 136
                      },
                      __self: this
                    },
                    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                      'i',
                      { className: 'material-icons d-inline-block align-top', __source: {
                          fileName: _jsxFileName,
                          lineNumber: 137
                        },
                        __self: this
                      },
                      'power_settings_new'
                    ),
                    'Sign Out'
                  )
                )
              )
            )
          )
        )
      );
    }
  }]);

  return NavBarApp;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

var mapStateToProps = function mapStateToProps(state) {
  return {
    isOpenSideBar: state.sidebar.isOpenSideBar
  };
};

var mapDispatchToProps = function mapDispatchToProps(dispatch) {
  return {
    controlSideBar: function controlSideBar(isOpenSideBar) {
      Object(__WEBPACK_IMPORTED_MODULE_8__actions__["a" /* openSideBar */])(dispatch, isOpenSideBar);
    }
  };
};

NavBarApp.propTypes = {
  apptitle: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.string.isRequired,
  isOpenSideBar: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.bool.isRequired
  // controlSideBar: PropTypes.func.isRequired
};

/* harmony default export */ __webpack_exports__["a"] = (Object(__WEBPACK_IMPORTED_MODULE_4_react_redux__["b" /* connect */])(mapStateToProps, mapDispatchToProps)(NavBarApp));

/***/ }),

/***/ "./src/components/UIComponents/Bar/NavBarApp/actions.js":
/*!**************************************************************!*\
  !*** ./src/components/UIComponents/Bar/NavBarApp/actions.js ***!
  \**************************************************************/
/*! exports provided: openSideBar */
/*! exports used: openSideBar */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = openSideBar;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__actionTypes__ = __webpack_require__(/*! ./actionTypes */ "./src/components/UIComponents/Bar/NavBarApp/actionTypes.js");


function openSideBar(dispatch, isOpenSideBar) {
  dispatch({
    type: __WEBPACK_IMPORTED_MODULE_0__actionTypes__["a" /* OPEN_SIDEBAR */],
    isOpenSideBar: !isOpenSideBar
  });
}

/***/ }),

/***/ "./src/components/UIComponents/Bar/NavBarApp/img/TriAzurIcon.png":
/*!***********************************************************************!*\
  !*** ./src/components/UIComponents/Bar/NavBarApp/img/TriAzurIcon.png ***!
  \***********************************************************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/media/TriAzurIcon.40ace683.png";

/***/ }),

/***/ "./src/components/UIComponents/Bar/NavBarApp/img/fr.svg":
/*!**************************************************************!*\
  !*** ./src/components/UIComponents/Bar/NavBarApp/img/fr.svg ***!
  \**************************************************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/media/fr.24841de9.svg";

/***/ }),

/***/ "./src/components/UIComponents/Bar/NavBarApp/img/gb.svg":
/*!**************************************************************!*\
  !*** ./src/components/UIComponents/Bar/NavBarApp/img/gb.svg ***!
  \**************************************************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/media/gb.fd72d9b5.svg";

/***/ }),

/***/ "./src/components/UIComponents/Bar/SideBar/SideBar.jsx":
/*!*************************************************************!*\
  !*** ./src/components/UIComponents/Bar/SideBar/SideBar.jsx ***!
  \*************************************************************/
/*! exports provided: default */
/*! exports used: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__styles_SideBar_css__ = __webpack_require__(/*! ./styles/SideBar.css */ "./src/components/UIComponents/Bar/SideBar/styles/SideBar.css");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__styles_SideBar_css___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__styles_SideBar_css__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_react_router_dom__ = __webpack_require__(/*! react-router-dom */ "./node_modules/react-router-dom/es/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_reactstrap__ = __webpack_require__(/*! reactstrap */ "./node_modules/reactstrap/dist/reactstrap.es.js");
var _jsxFileName = '/Users/alexiszrihen/Desktop/three_modules/triazur/src/components/UIComponents/Bar/SideBar/SideBar.jsx',
    _this = this;







var SideBar = function SideBar(_ref) {
  var isOpenSideBar = _ref.isOpenSideBar,
      itemSideBar = _ref.itemSideBar;
  return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
    'div',
    { className: isOpenSideBar ? 'sidebar-open' : 'sidebar-close', __source: {
        fileName: _jsxFileName,
        lineNumber: 14
      },
      __self: _this
    },
    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
      __WEBPACK_IMPORTED_MODULE_4_reactstrap__["z" /* Nav */],
      { id: 'sidebar-wrapper', __source: {
          fileName: _jsxFileName,
          lineNumber: 15
        },
        __self: _this
      },
      __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'ul',
        { className: 'sidebar-nav nav-pills nav-stacked', id: 'menu', __source: {
            fileName: _jsxFileName,
            lineNumber: 16
          },
          __self: _this
        },
        itemSideBar.map(function (item) {
          return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            __WEBPACK_IMPORTED_MODULE_4_reactstrap__["A" /* NavItem */],
            { key: item.title, __source: {
                fileName: _jsxFileName,
                lineNumber: 19
              },
              __self: _this
            },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              __WEBPACK_IMPORTED_MODULE_3_react_router_dom__["a" /* Link */],
              { to: item.path, id: 'sidebarItem', __source: {
                  fileName: _jsxFileName,
                  lineNumber: 20
                },
                __self: _this
              },
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement('img', { src: item.img, alt: item.title, __source: {
                  fileName: _jsxFileName,
                  lineNumber: 21
                },
                __self: _this
              }),
              item.title
            )
          );
        })
      )
    )
  );
};

SideBar.propTypes = {
  isOpenSideBar: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.bool.isRequired,
  itemSideBar: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.arrayOf(__WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.object).isRequired
};

/* harmony default export */ __webpack_exports__["a"] = (SideBar);

/***/ }),

/***/ "./src/components/UIComponents/Bar/SideBar/styles/SideBar.css":
/*!********************************************************************!*\
  !*** ./src/components/UIComponents/Bar/SideBar/styles/SideBar.css ***!
  \********************************************************************/
/*! dynamic exports provided */
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(/*! !../../../../../../node_modules/css-loader??ref--1-oneOf-3-1!../../../../../../node_modules/postcss-loader/lib??postcss!./SideBar.css */ "./node_modules/css-loader/index.js?{\"importLoaders\":1}!./node_modules/postcss-loader/lib/index.js?{\"ident\":\"postcss\",\"plugins\":[null,null]}!./src/components/UIComponents/Bar/SideBar/styles/SideBar.css");
if(typeof content === 'string') content = [[module.i, content, '']];
// Prepare cssTransformation
var transform;

var options = {"hmr":true}
options.transform = transform
// add the styles to the DOM
var update = __webpack_require__(/*! ../../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);
if(content.locals) module.exports = content.locals;
// Hot Module Replacement
if(true) {
	// When the styles change, update the <style> tags
	if(!content.locals) {
		module.hot.accept(/*! !../../../../../../node_modules/css-loader??ref--1-oneOf-3-1!../../../../../../node_modules/postcss-loader/lib??postcss!./SideBar.css */ "./node_modules/css-loader/index.js?{\"importLoaders\":1}!./node_modules/postcss-loader/lib/index.js?{\"ident\":\"postcss\",\"plugins\":[null,null]}!./src/components/UIComponents/Bar/SideBar/styles/SideBar.css", function() {
			var newContent = __webpack_require__(/*! !../../../../../../node_modules/css-loader??ref--1-oneOf-3-1!../../../../../../node_modules/postcss-loader/lib??postcss!./SideBar.css */ "./node_modules/css-loader/index.js?{\"importLoaders\":1}!./node_modules/postcss-loader/lib/index.js?{\"ident\":\"postcss\",\"plugins\":[null,null]}!./src/components/UIComponents/Bar/SideBar/styles/SideBar.css");
			if(typeof newContent === 'string') newContent = [[module.i, newContent, '']];
			update(newContent);
		});
	}
	// When the module is disposed, remove the <style> tags
	module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./src/components/UIComponents/Field/DropDownApp/DropDownApp.jsx":
/*!***********************************************************************!*\
  !*** ./src/components/UIComponents/Field/DropDownApp/DropDownApp.jsx ***!
  \***********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_reactstrap__ = __webpack_require__(/*! reactstrap */ "./node_modules/reactstrap/dist/reactstrap.es.js");
var _jsxFileName = '/Users/alexiszrihen/Desktop/three_modules/triazur/src/components/UIComponents/Field/DropDownApp/DropDownApp.jsx';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }




var DropDownApp = function (_React$Component) {
  _inherits(DropDownApp, _React$Component);

  function DropDownApp(props) {
    _classCallCheck(this, DropDownApp);

    var _this = _possibleConstructorReturn(this, (DropDownApp.__proto__ || Object.getPrototypeOf(DropDownApp)).call(this, props));

    _this.toggle = _this.toggle.bind(_this);
    _this.state = {
      dropdownOpen: false
    };
    return _this;
  }

  _createClass(DropDownApp, [{
    key: 'toggle',
    value: function toggle() {
      this.setState({
        dropdownOpen: !this.state.dropdownOpen
      });
    }
  }, {
    key: 'render',
    value: function render() {
      return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        __WEBPACK_IMPORTED_MODULE_1_reactstrap__["o" /* Dropdown */],
        { isOpen: this.state.dropdownOpen, toggle: this.toggle, __source: {
            fileName: _jsxFileName,
            lineNumber: 22
          },
          __self: this
        },
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          __WEBPACK_IMPORTED_MODULE_1_reactstrap__["r" /* DropdownToggle */],
          {
            tag: 'span',
            onClick: this.toggle,
            'data-toggle': 'dropdown',
            'aria-expanded': this.state.dropdownOpen,
            __source: {
              fileName: _jsxFileName,
              lineNumber: 23
            },
            __self: this
          },
          'Custom Dropdown Content'
        ),
        __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
          __WEBPACK_IMPORTED_MODULE_1_reactstrap__["q" /* DropdownMenu */],
          {
            __source: {
              fileName: _jsxFileName,
              lineNumber: 31
            },
            __self: this
          },
          __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
            __WEBPACK_IMPORTED_MODULE_1_reactstrap__["F" /* Row */],
            {
              __source: {
                fileName: _jsxFileName,
                lineNumber: 32
              },
              __self: this
            },
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              __WEBPACK_IMPORTED_MODULE_1_reactstrap__["l" /* Col */],
              { sm: 6, __source: {
                  fileName: _jsxFileName,
                  lineNumber: 33
                },
                __self: this
              },
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                'div',
                { onClick: this.toggle, __source: {
                    fileName: _jsxFileName,
                    lineNumber: 34
                  },
                  __self: this
                },
                'Item 1'
              ),
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                'div',
                { onClick: this.toggle, __source: {
                    fileName: _jsxFileName,
                    lineNumber: 35
                  },
                  __self: this
                },
                'Item 2'
              )
            ),
            __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
              __WEBPACK_IMPORTED_MODULE_1_reactstrap__["l" /* Col */],
              { sm: 6, __source: {
                  fileName: _jsxFileName,
                  lineNumber: 37
                },
                __self: this
              },
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                'div',
                { onClick: this.toggle, __source: {
                    fileName: _jsxFileName,
                    lineNumber: 38
                  },
                  __self: this
                },
                'Item 3'
              ),
              __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
                'div',
                { onClick: this.toggle, __source: {
                    fileName: _jsxFileName,
                    lineNumber: 39
                  },
                  __self: this
                },
                'Item 4'
              )
            )
          )
        )
      );
    }
  }]);

  return DropDownApp;
}(__WEBPACK_IMPORTED_MODULE_0_react___default.a.Component);

/* unused harmony default export */ var _unused_webpack_default_export = (DropDownApp);

/***/ }),

/***/ "./src/scenes/ConcreteSection/ConcreteSection.jsx":
/*!********************************************************!*\
  !*** ./src/scenes/ConcreteSection/ConcreteSection.jsx ***!
  \********************************************************/
/*! exports provided: default */
/*! all exports used */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react__ = __webpack_require__(/*! react */ "./node_modules/react/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_react___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_react__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_prop_types___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_prop_types__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_react_router_dom__ = __webpack_require__(/*! react-router-dom */ "./node_modules/react-router-dom/es/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_reactstrap__ = __webpack_require__(/*! reactstrap */ "./node_modules/reactstrap/dist/reactstrap.es.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_react_redux__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__components_UIComponents_Bar_NavBarApp__ = __webpack_require__(/*! ../../components/UIComponents/Bar/NavBarApp */ "./src/components/UIComponents/Bar/NavBarApp/NavBarApp.jsx");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__components_UIComponents_Bar_SideBar__ = __webpack_require__(/*! ../../components/UIComponents/Bar/SideBar */ "./src/components/UIComponents/Bar/SideBar/SideBar.jsx");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__components_GraphicModules_Background_AppBackground__ = __webpack_require__(/*! ../../components/GraphicModules/Background/AppBackground */ "./src/components/GraphicModules/Background/AppBackground/AppBackground.jsx");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__img_Projects_svg__ = __webpack_require__(/*! ./img/Projects.svg */ "./src/scenes/ConcreteSection/img/Projects.svg");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__img_Projects_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_8__img_Projects_svg__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__img_Documentation_svg__ = __webpack_require__(/*! ./img/Documentation.svg */ "./src/scenes/ConcreteSection/img/Documentation.svg");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__img_Documentation_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_9__img_Documentation_svg__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__img_Dashboard_svg__ = __webpack_require__(/*! ./img/Dashboard.svg */ "./src/scenes/ConcreteSection/img/Dashboard.svg");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__img_Dashboard_svg___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10__img_Dashboard_svg__);
var _jsxFileName = '/Users/alexiszrihen/Desktop/three_modules/triazur/src/scenes/ConcreteSection/ConcreteSection.jsx',
    _this = this;














var itemSideBar = [{
  path: '/concretesection/projects',
  img: __WEBPACK_IMPORTED_MODULE_8__img_Projects_svg___default.a,
  title: 'Projects'
}, {
  path: '/concretesection/documentation',
  img: __WEBPACK_IMPORTED_MODULE_9__img_Documentation_svg___default.a,
  title: 'Documentation'
}, {
  path: '/concretesection/randomconcretesection',
  img: __WEBPACK_IMPORTED_MODULE_10__img_Dashboard_svg___default.a,
  title: 'Dashboard'
}];

var ConcreteSection = function ConcreteSection(_ref) {
  var isOpenSideBar = _ref.isOpenSideBar,
      children = _ref.children;
  return __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
    'div',
    {
      __source: {
        fileName: _jsxFileName,
        lineNumber: 36
      },
      __self: _this
    },
    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_5__components_UIComponents_Bar_NavBarApp__["a" /* default */], {
      apptitle: 'TriAzur',
      isOpenSideBar: isOpenSideBar,
      __source: {
        fileName: _jsxFileName,
        lineNumber: 37
      },
      __self: _this
    }),
    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_7__components_GraphicModules_Background_AppBackground__["a" /* default */], {
      __source: {
        fileName: _jsxFileName,
        lineNumber: 41
      },
      __self: _this
    }),
    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(__WEBPACK_IMPORTED_MODULE_6__components_UIComponents_Bar_SideBar__["a" /* default */], {
      isOpenSideBar: isOpenSideBar,
      itemSideBar: itemSideBar,
      __source: {
        fileName: _jsxFileName,
        lineNumber: 42
      },
      __self: _this
    }),
    __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
      __WEBPACK_IMPORTED_MODULE_3_reactstrap__["n" /* Container */],
      { className: 'concretesection-container', __source: {
          fileName: _jsxFileName,
          lineNumber: 46
        },
        __self: _this
      },
      __WEBPACK_IMPORTED_MODULE_0_react___default.a.createElement(
        'div',
        {
          __source: {
            fileName: _jsxFileName,
            lineNumber: 47
          },
          __self: _this
        },
        children
      )
    )
  );
};

ConcreteSection.propTypes = {
  isOpenSideBar: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.bool.isRequired,
  children: __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.oneOfType([__WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.node, __WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.arrayOf(__WEBPACK_IMPORTED_MODULE_1_prop_types___default.a.node)]).isRequired
};

var mapStateToProps = function mapStateToProps(state) {
  return {
    isOpenSideBar: state.sidebar.isOpenSideBar
  };
};

var mapDispatchToProps = function mapDispatchToProps(dispatch) {
  return {
    // controlSideBar: (isOpenSideBar) => { openSideBar(dispatch, isOpenSideBar); }
  };
};

/* harmony default export */ __webpack_exports__["default"] = (Object(__WEBPACK_IMPORTED_MODULE_4_react_redux__["b" /* connect */])(mapStateToProps, mapDispatchToProps)(ConcreteSection));

/***/ }),

/***/ "./src/scenes/ConcreteSection/img/Dashboard.svg":
/*!******************************************************!*\
  !*** ./src/scenes/ConcreteSection/img/Dashboard.svg ***!
  \******************************************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/media/Dashboard.3252bbe7.svg";

/***/ }),

/***/ "./src/scenes/ConcreteSection/img/Documentation.svg":
/*!**********************************************************!*\
  !*** ./src/scenes/ConcreteSection/img/Documentation.svg ***!
  \**********************************************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/media/Documentation.ac711143.svg";

/***/ }),

/***/ "./src/scenes/ConcreteSection/img/Projects.svg":
/*!*****************************************************!*\
  !*** ./src/scenes/ConcreteSection/img/Projects.svg ***!
  \*****************************************************/
/*! dynamic exports provided */
/*! exports used: default */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__.p + "static/media/Projects.f99274d3.svg";

/***/ })

});
//# sourceMappingURL=1.chunk.js.map