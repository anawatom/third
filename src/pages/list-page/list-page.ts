import { Component } from '@angular/core';

import { NavController, NavParams } from 'ionic-angular';

// providers
import { ListData } from '../../providers/list-data/list-data';

@Component({
  selector: 'list-page',
  templateUrl: 'list-page.html',
  providers: [ListData]
})
export class ListPage {
  public title: string = '';
  // public listData: any[] = [];

  constructor(
    private navCtrl: NavController,
    private navParams: NavParams,
    private listData: ListData
  ) {
    this.title = this.navParams.get('title');
    this.listData.fetchData(this.navParams.get('htmlContent'))
    .subscribe(
      (res: any) => {
        console.log(res);
      },
      (error: any) => {
        console.error(error);
      },
      () => {
        console.log('finally');
        // loader.dismiss();
        // console.log(this.menuList);
      }
    )
  }


}
