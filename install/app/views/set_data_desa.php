<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
                <div class="form-group has-feedback">
                    <input type="text" name="desa" class="form-control" placeholder="Nama desa" required/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
				<div class="form-group has-feedback">
                    <input type="text" name="kec" class="form-control" placeholder="Nama kecamatan" required/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
				<div class="form-group has-feedback">
                    <input type="text" name="kab" class="form-control" placeholder="Nama kabupaten"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
				<div class="form-group has-feedback">
                    <input type="text" name="prov" class="form-control" placeholder="Nama provinsi" required/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <select class="form-control" name="timezone" required>
                        <option value="Asia/Jakarta" selected>Asia/Jakarta</option>
                        <option value="Asia/Makassar">Asia/Makassar</option>
                        <option value="Asia/Jayapura">Asia/Jayapura</option>
                    </select>
                </div>


                