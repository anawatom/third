import { Component } from '@angular/core';

import { NavController, NavParams } from 'ionic-angular';

// providers
import { ListData } from '../../providers/list-data/list-data';
import { LoaderHelper } from '../../providers/loader-helper/loader-helper';

// Pipes
import { SafeHtml } from '../../pipes/safe-html';

// Pages
import { DetailPage } from '../detail-page/detail-page';

@Component({
  selector: 'list-page',
  templateUrl: 'list-page.html',
  providers: [ListData, LoaderHelper]
})
export class ListPage {
  public title: string = '';
  // @TODO: data should be move to list-data provider
  public data: Array<{id: number,
                        type: string,
                        imagePath: string,
                        filePath: string,
                        title: string,
                        description?: string
                        htmlDescription?: string}> = null;

  constructor(
    private navCtrl: NavController,
    private navParams: NavParams,
    private loaderHelper: LoaderHelper,
    private listData: ListData
  ) {
    this.title = this.navParams.get('title');

    this.loaderHelper.show();
    this.listData.fetchData(this.navParams.get('htmlContent'))
    .subscribe(
      (res: any) => {
        this.data = res;
        this.loaderHelper.hide();
        console.log('List data: ', this.data);
      },
      (error: any) => {
        console.log(error);
        this.data = [];
        this.loaderHelper.hide();
      }
    );
  }

  openDetailPage(id: number, title: string, type: string) {
    console.log(type, id);
    this.navCtrl.push(DetailPage, {
      id: id,
      title: title,
      type: type
    });
  }

}
