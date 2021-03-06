import { Component, ViewChild } from '@angular/core';
import { Nav, Platform, MenuController, LoadingController } from 'ionic-angular';
import { StatusBar, Splashscreen } from 'ionic-native';
import _ from 'lodash';

// Components
import { MenuOptionModel, SideMenuContentComponent } from '../components/side-menu/side-menu';

// Providers
import { MenuData } from '../providers/menu-data/menu-data';
import { LoaderHelper } from '../providers/loader-helper/loader-helper';

// Pages
import { MainPage } from '../pages/main-page/main-page';
import { HtmlPage } from '../pages/html-page/html-page';
import { ListPage } from '../pages/list-page/list-page';

@Component({
  templateUrl: 'app.html',
  providers: [MenuData, LoaderHelper]
})
export class MyApp {
  @ViewChild(Nav) nav: Nav;
  @ViewChild(SideMenuContentComponent) sideMenu: SideMenuContentComponent;

  public menuList: Array<MenuOptionModel> = [];
  public rootPage: any = MainPage;
  private expandMenuIconName: string = 'ios-arrow-down';

  constructor(
    public platform: Platform,
    public loadingCtrl: LoadingController,
    private loader: LoaderHelper,
    private menuData: MenuData,
    private menuCtrl: MenuController
  ) {
    this.initializeApp();
  }

  initializeApp() {
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();
      Splashscreen.hide();

      this.loader.show();
      this.menuData.getAllData()
      .subscribe(
        (res: any) => {
          // @TODO: Make it to be recrusive style, right now it fix to has 3 level
          let groupMenuLevel1 = _.groupBy(res, 'MenuId');
          let tmpMenuList = [];
          _.each(groupMenuLevel1, (subMenus: any, i: number) => {
            let menu = <MenuOptionModel>{};
            let menuLevel2List: Array<MenuOptionModel> = [];
            let groupMenuLevel2 = _.groupBy(subMenus, (e, i) => { return e.GIVING_INFO_SUBMENU2.SubId; });
            _.each(groupMenuLevel2, (level3Menus: any, i: number) => {
              let menuLevel3List: Array<MenuOptionModel> = [];
              _.each(level3Menus, (level3Menu: any, i: number) => {
                if (level3Menu.GIVING_INFO_SUBMENU3.SubNameTH
                    || level3Menu.GIVING_INFO_SUBMENU3.SubDetailTH
                    || level3Menu.GIVING_INFO_SUBMENU3.SubPicTH) {
                  menuLevel3List.push(
                    this.getMenuObject(level3Menu.GIVING_INFO_SUBMENU3)
                  );
                }
              });

              let menuLevel2: any = {};
              menuLevel2 = this.getMenuObject(level3Menus[0].GIVING_INFO_SUBMENU2);
              if (menuLevel3List.length > 0) {
                menuLevel2.iconName = this.expandMenuIconName;
                menuLevel2.subItems = menuLevel3List;
              }
              menuLevel2List.push(menuLevel2);
            });

            menu.menuId = subMenus[0].MenuId;
            if (menuLevel2List.length > 0) {
              menu.iconName = this.expandMenuIconName;
              menu.subItems = menuLevel2List;
            } else {
              menu.iconName = 'ios-apps';
            }
            menu.displayName = subMenus[0].MenuNameTH;
            menu.component = HtmlPage || null;
            menu.isLogin = false;
            menu.isLogout = false;
            tmpMenuList.push(menu);
          });
          this.menuList = tmpMenuList;
        },
        (error: any) => {
          console.error(error);
        },
        () => {
          this.loader.hide();
          console.log(this.menuList);
          console.log('finally');
      });
    });
  }

  private getMenuObject(menuObj: {SubId: number,
                                  SubSortId: number,
                                  SubNameTH: string,
                                  SubDetailTH: string,
                                  SubDetailEN: string,
                                  SubPicTH: string,
                                  SubPicEN: string,
                                  SubUrlTH: string,
                                  SubUrlEN: string}) {
      let component: any = null;
      let content: string = '';
      if (menuObj.SubDetailTH !== '' || menuObj.SubPicTH !== '') {
        component = HtmlPage;
        content = menuObj.SubDetailTH;
        if (menuObj.SubPicTH !== '') {
          content += '<center><img src="/content/images/submenu/' + menuObj.SubPicTH + '"></img></center>';
        }
      } else {
        component = ListPage;
        content = menuObj.SubUrlTH;
      }

      return {menuId: menuObj.SubId,
              iconName: 'ios-apps',
              displayName: menuObj.SubNameTH,
              component: component,
              htmlContent: content, // @TODO: htmlContent key should be changed to content
              isLogin: false,
              isLogout: false};
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
      this.nav.push(option.component || MainPage, {
        'title': option.displayName,
        'htmlContent': option.htmlContent // @TODO: htmlContent key should be changed to content
      });
    });
  }

  public collapseMenuOptions(): void {
    // Collapse all the options
    this.sideMenu.collapseAllOptions();
  }
}
