import { Injectable } from '@angular/core';
import { Http, URLSearchParams, Response } from '@angular/http';
import { Observable } from 'rxjs/Rx';
import 'rxjs/add/operator/map';

/*
  Generated class for the Testing provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class MenuData {
  constructor(private http: Http) {}

  getAllData(): Observable<MenuData[]> {
    let params = new URLSearchParams();
    params.set('MenuId', '');

    return this.http.get('http://mobile.dpe.go.th/web/index.php?r=ws/service/get-tbl-menu', {
      'search': params
    })
    .map((res: Response) => {
      return res.json();
    });
  }
}
