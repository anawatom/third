import { Component, ViewChild } from '@angular/core';
import { Nav, Platform, MenuController } from 'ionic-angular';
import { StatusBar, Splashscreen } from 'ionic-native';

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

  public options: Array<MenuOptionModel>;

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

    this.menuData.getAllData()
    .subscribe(
      (res: any) => {
        console.log(res);
      },
      (error: any) => {
        console.error(error);
      },
      () => {
        console.log('finally');
        this.initializeApp();
      }
    );
  }

  initializeApp() {
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();
      Splashscreen.hide();

      // TODO: replace by real options
      this.options = this.sideMenu.getSampleMenuOptions(Page1);
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
      this.nav.push(option.component || Page1, { 'title': option.displayName });
    });
  }

  public collapseMenuOptions(): void {
    // Collapse all the options
    this.sideMenu.collapseAllOptions();
  }
}
