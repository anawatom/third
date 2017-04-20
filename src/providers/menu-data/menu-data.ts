import { Injectable } from '@angular/core';
import { Http, URLSearchParams, Response } from '@angular/http';
import { Observable } from 'rxjs/Rx';
import 'rxjs/add/operator/map';

import { BASE_API_URL } from '../constant.ts';

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

    return this.http.get(BASE_API_URL + 'ws/service/get-tbl-menu', {
      'search': params
    })
    .map((res: Response) => {
      return res.json().data;
    });
  }
}
