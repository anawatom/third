import { Component, ViewChild } from '@angular/core';
import { Nav, Platform, MenuController } from 'ionic-angular';
import { StatusBar, Splashscreen } from 'ionic-native';
import _ from 'lodash';

import { MenuOptionModel, SideMenuContentComponent } from '../components/side-menu/side-menu';

import { MenuData } from '../providers/menu-data/menu-data';

import { Page1 } from '../pages/page1/page1';
import { Page2 } from '../pages/page2/page2';


@Component({
  templateUrl: 'app.html',
  providers: [MenuData]
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;
  @ViewChild(SideMenuContentComponent) sideMenu: SideMenuContentComponent;

  public menuList: Array<MenuOptionModel> = [];

  rootPage: any = Page1;

  // pages: Array<{title: string, component: any}>;

  constructor(
    public platform: Platform,
    private menuData: MenuData,
    private menuCtrl: MenuController
  ) {
    // used for an example of ngFor and navigation
    // this.pages = [
    //   { title: 'Page One', component: Page1 },
    //   { title: 'Page Two', component: Page2 }
    // ];

    this.initializeApp();
  }

  initializeApp() {
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();
      Splashscreen.hide();

      // @TODO: This function should be moved to menu provider
      this.menuData.getAllData()
      .subscribe(
        (res: any) => {
          // @TODO: Make it to be recrusive style, right now it fix to has 3 level
          let groupMenuLevel1 = _.groupBy(res, 'MenuId');
          let tmpMenuList = [];
          _.each(groupMenuLevel1, (subMenus: any, i: number) => {
            let menu = <MenuOptionModel>{};
            let menuLevel2List: Array<MenuOptionModel> = [];
            // if (typeof subMenus[0].GIVING_INFO_SUBMENU3 === 'string') {
            //   _.each(subMenus, (subMenu: any, i2: number) => {
            //     menuLevel2List.push({
            //       menuId: subMenu.GIVING_INFO_SUBMENU2.SubId,
            //       iconName: 'ios-basket',
            //       displayName: subMenu.GIVING_INFO_SUBMENU2.SubNameTH,
            //       component: Page2 || null,
            //       isLogin: false,
            //       isLogout: false
            //     });
            //   });
            // } else { // Have level 3
              let groupMenuLevel2 = _.groupBy(subMenus, (e, i) => { return e.GIVING_INFO_SUBMENU2.SubId; });
              _.each(groupMenuLevel2, (level3Menus: any, i: number) => {
                // let menuLevel3List: Array<MenuOptionModel> = [];
                // _.each(level3Menus, (level3Menu: any, i: number) => {
                //   menuLevel3List.push({
                //     menuId: level3Menu.GIVING_INFO_SUBMENU3.SubId,
                //     iconName: 'ios-basket',
                //     displayName: level3Menu.GIVING_INFO_SUBMENU3.SubNameTH,
                //     component: Page2 || null,
                //     isLogin: false,
                //     isLogout: false
                //   });
                // });
                menuLevel2List.push({
                  menuId: level3Menus[0].GIVING_INFO_SUBMENU2.SubId,
                  iconName: 'ios-open',
                  displayName: level3Menus[0].GIVING_INFO_SUBMENU2.SubNameTH,
                  component: Page2 || null,
                  htmlContent: level3Menus[0].GIVING_INFO_SUBMENU2.SubDetailTH,
                  isLogin: false,
                  isLogout: false
                });
              });
            // }

            menu.menuId = subMenus[0].MenuId;
            if (menuLevel2List.length > 0) {
              menu.iconName = 'ios-arrow-down';
              menu.subItems = menuLevel2List;
            } else {
              menu.iconName = 'ios-apps';
            }
            menu.displayName = subMenus[0].MenuNameTH;
            menu.component = Page2 || null;
            menu.isLogin = false;
            menu.isLogout = false;
            tmpMenuList.push(menu);
          });
          this.menuList = tmpMenuList;

          // this.menuList = this.sideMenu.getSampleMenuOptions(Page2);
        },
        (error: any) => {
          console.error(error);
        },
        () => {
          console.log(this.menuList);
          console.log('finally');
      });
    });
  }

  // openPage(page) {
  //   // Reset the content nav to have just this page
  //   // we wouldn't want the back button to show in this scenario
  //   this.nav.setRoot(page.component);
  // }

  // Redirect the user to the selected page
  public selectOption(option: MenuOptionModel): void {
    this.menuCtrl.close().then(() => {

      // Collapse all the options
      this.sideMenu.collapseAllOptions();

      // Redirect to the selected page
      this.nav.push(option.component || Page1, {
        'title': option.displayName,
        'htmlContent': option.htmlContent
      });
    });
  }

  public collapseMenuOptions(): void {
    // Collapse all the options
    this.sideMenu.collapseAllOptions();
  }
}
