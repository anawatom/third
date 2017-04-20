import { Injectable } from '@angular/core';
import { Http, URLSearchParams, Response } from '@angular/http';
import { Observable } from 'rxjs/Rx';
import 'rxjs/add/operator/map';
import _ from 'lodash';

/*
  Generated class for the Testing provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class ListData {
  constructor(private http: Http) {}

  fetchData(url: string): Observable<ListData[]> {
    let urlData = this.formatURL(url);
    let params = new URLSearchParams();
    if (urlData.params) {
      _.each(urlData.params, (e, i) => {
        let splitValue = e.split('='); // Format name=value
        params.set(splitValue[0], splitValue[1]);
      });
    }

    return this.http.get(urlData.url, {
      'search': params
    })
    .map((res: Response) => {
      return res.json().data;
    });
  }

  /*
  * @params
  *   url => /th/manager/11
  */
  private formatURL(url: string) {
    let result: any = {};
    let splitURL = url.split('/');
    let id: number = 0;
    if ( !isNaN(parseInt(splitURL[splitURL.length - 1])) ) {
      id = parseInt(splitURL[splitURL.length - 1]);
    }

    if (url.indexOf('manager') !== -1) {
      result = {
        'url': 'http://mobile.dpe.go.th/web/index.php?r=ws/service/get-tbl-manager&Manager',
        'params': [
          'ManagerDepartmentId=' + id
        ]
      };
    }

    return result;
  }
}
