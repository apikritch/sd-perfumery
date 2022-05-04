import Vue from "vue";
import VueRouter from "vue-router";

//All Route For Customer
import Home from "@/components/Customer/Content/Home/Home.vue";
import ShopLayout from "@/components/Customer/Content/Shop/ShopLayout.vue";
import Shop from "@/components/Customer/Content/Shop/Shop/Shop.vue";
import ContactUs from "@/components/Customer/Content/ContactUs/ContactUs.vue";
import Cart from "@/components/Customer/Content/Cart/Cart.vue";
import Checkout from "@/components/Customer/Content/Checkout/Checkout.vue";
import MyAccountLayout from "@/components/Customer/Content/MyAccount/MyAccountLayout.vue";
import MyAccount from "@/components/Customer/Content/MyAccount/MyAccount/MyAccount.vue";
import MyOrder from "@/components/Customer/Content/MyAccount/MyOrder/MyOrder.vue";
import OrderDetail from "@/components/Customer/Content/MyAccount/MyOrder/OrderDetail.vue";
import SideBar from "@/components/Customer/Content/MyAccount/SideBar/SideBar.vue";
import FilterProduct from "@/components/Customer/Content/Shop/FilterProduct/FilterProduct.vue";
import Product from "@/components/Customer/Content/Product/Product.vue";
import Customer from "@/components/Customer/Customer.vue";
import Login from "@/components/Customer/Login.vue";
import ResetPassword from "@/components/Customer/Content/ResetPassword/ResetPassword.vue";
import NotFound from "@/components/Customer/Content/404/NotFound.vue";
import ThankYou from "@/components/Customer/Content/ThankYou/ThankYou.vue";

//All Route For Admin
import AdminLanding from "@/components/Admin/AdminLanding.vue";
import DashBoard from "@/components/Admin/Content/DashBoard/DashBoard.vue";
import ProductList from "@/components/Admin/Content/ProductList/ProductList.vue";
import OrderList from "@/components/Admin/Content/OrderList/OrderList.vue";
import CustomerList from "@/components/Admin/Content/CustomerList/CustomerList.vue";
import UIComponent from "@/components/Admin/Content/UIComponent/UIComponent.vue";
import UserList from "@/components/Admin/Content/UserList/UserList.vue";
import AdminMyAccount from "@/components/Admin/Content/AdminMyAccount/AdminMyAccount.vue";
import AddProduct from "@/components/Admin/Content/ProductList/AddProduct.vue";
import AddUIComponent from "@/components/Admin/Content/UIComponent/AddUIComponent.vue";
import AddUser from "@/components/Admin/Content/UserList/AddUser.vue";
import EditProduct from "@/components/Admin/Content/ProductList/EditProduct.vue";
import EditComponent from "@/components/Admin/Content/UIComponent/EditUIComponent.vue";
import AdminResetPassword from "@/components/Admin/AdminResetPassword.vue";
import AdminForgotPassword from "@/components/Admin/AdminForgotPassword.vue";
import AdminOrderDetails from "@/components/Admin/Content/OrderList/AdminOrderDetails.vue";
import BrandList from "@/components/Admin/Content/Brand/BrandList.vue";
import EditBrand from "@/components/Admin/Content/Brand/EditBrand.vue";
import AddBrand from "@/components/Admin/Content/Brand/AddBrand.vue";
import Shipment from "@/components/Admin/Content/Shipment/Shipment.vue";
import AddShipment from "@/components/Admin/Content/Shipment/AddShipment.vue";
import EditShipment from "@/components/Admin/Content/Shipment/EditShipment.vue";

Vue.use(VueRouter);

export default new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/",
      component: Customer,
      children: [
        { path: "/", name: "Home", component: Home },
        { path: "/contactus", component: ContactUs },
        { path: "/cart", name: "Cart", component: Cart },
        { path: "/login", component: Login },
        { path: "/checkout", component: Checkout },
        { path: "/thankyou", name: "ThankYou", component: ThankYou },
        {
          path: "/product/:productId",
          name: "Product",
          component: Product,
        },
        {
          path: "/shop",
          component: ShopLayout,
          prop: true,
          children: [
            {
              path: "/shop",
              name: "SHOP",
              components: {
                default: FilterProduct,
                shop_content: Shop,
              },
              props: {
                default: true,
                shop_content: true,
              },
            },
            {
              path: "/shop/women",
              name: "WOMEN",
              components: {
                default: FilterProduct,
                shop_content: Shop,
              },
              props: {
                default: true,
                shop_content: true,
              },
            },
            {
              path: "/shop/men",
              name: "MEN",
              components: {
                default: FilterProduct,
                shop_content: Shop,
              },
              props: {
                default: true,
                shop_content: true,
              },
            },
            {
              path: "/shop/unisex",
              name: "UNISEX",
              components: {
                default: FilterProduct,
                shop_content: Shop,
              },
              props: {
                default: true,
                shop_content: true,
              },
            },
          ],
        },
        {
          path: "/myaccount",
          component: MyAccountLayout,
          children: [
            {
              path: "/myaccount",
              components: {
                default: SideBar,
                my_account_content: MyAccount,
              },
            },
            {
              path: "/myaccount/order",
              components: {
                default: SideBar,
                my_account_content: MyOrder,
              },
            },
            {
              path: "/myaccount/order/:orderId",
              components: {
                default: SideBar,
                my_account_content: OrderDetail,
              },
            },
          ],
        },
      ],
    },
    { path: "*", component: NotFound },
    { path: "/reset_password/:token", component: ResetPassword },
    { path: "/admin/reset_password/:token", component: AdminResetPassword },
    { path: "/admin/forgot_password", component: AdminForgotPassword },

    {
      path: "/admin",
      component: AdminLanding,
      children: [
        {
          path: "/admin",
          name: "DashBoard",
          component: DashBoard,
        },
        {
          path: "/admin/product",
          name: "ProductList",
          component: ProductList,
        },
        {
          path: "/admin/product/add",
          component: AddProduct,
        },
        {
          path: "/admin/product/:productId/edit",
          component: EditProduct,
        },
        {
          path: "/admin/shipment",
          name: "Shipment",
          component: Shipment,
        },
        {
          path: "/admin/shipment/add",
          component: AddShipment,
        },
        {
          path: "/admin/shipment/:shipmentId/edit",
          component: EditShipment,
        },
        {
          path: "/admin/brand",
          name: "BrandList",
          component: BrandList,
        },
        {
          path: "/admin/brand/add",
          component: AddBrand,
        },
        {
          path: "/admin/brand/:brandId/edit",
          component: EditBrand,
        },
        {
          path: "/admin/order",
          name: "OrderList",
          component: OrderList,
        },
        {
          path: "/admin/order/:orderId",
          name: "AdminOrderDetails",
          component: AdminOrderDetails,
        },
        {
          path: "/admin/customer",
          name: "CustomerList",
          component: CustomerList,
        },
        {
          path: "/admin/uicomponent",
          name: "UIComponent",
          component: UIComponent,
        },
        {
          path: "/admin/uicomponent/add",
          component: AddUIComponent,
        },
        {
          path: "/admin/uicomponent/:carouselId/edit",
          component: EditComponent,
        },
        {
          path: "/admin/user",
          name: "UserList",
          component: UserList,
        },
        {
          path: "/admin/user/add",
          component: AddUser,
        },
        {
          path: "/admin/myaccount",
          component: AdminMyAccount,
        },
      ],
    },
  ],
});
