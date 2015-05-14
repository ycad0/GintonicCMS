/**
 * @license The MIT License (MIT)
 *
 * Copyright (c) 2014 Felipe O. Carvalho
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

define(["JSXTransformer","text"],function(e,t){"use strict";var n={},r={version:"0.6.0",load:function(r,i,s,o){var u=o.jsx||{},a=u.fileExtension||".js",f={harmony:!!u.harmony,stripTypes:!!u.stripTypes},l=function(t){try{t=e.transform(t,f).code}catch(i){s.error(i)}o.isBuild?n[r]=t:typeof location!="undefined"&&(t+="\n//# sourceURL="+location.protocol+"//"+location.hostname+o.baseUrl+r+a),s.fromText(t)};l.error=function(e){s.error(e)},t.load(r+a,i,l,o)},write:function(e,t,r){if(n.hasOwnProperty(t)){var i=n[t];r.asModule(e+"!"+t,i)}}};return r});