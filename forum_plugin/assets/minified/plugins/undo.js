/* SCEditor v2.0.0 | (C) 2017, Sam Clarke | sceditor.com/license */

!function(e){"use strict";e.plugins.undo=function(){var e,t,r=this,o=0,u=50,a=[],n=[],c=!1,s=function(r){c=!0,t=r.value,e.sourceMode(r.sourceMode),e.val(r.value,!1),e.focus(),r.sourceMode?e.sourceEditorCaret(r.caret):e.getRangeHelper().restoreRange(),c=!1},l=function(e,t){var r,o,u,a,n=e.length,c=t.length,s=Math.max(n,c);for(r=0;r<s&&e.charAt(r)===t.charAt(r);r++);for(u=n<c?c-n:0,a=c<n?n-c:0,o=s-1;o>=0&&e.charAt(o-u)===t.charAt(o-a);o--);return o-r+1};r.init=function(){u=(e=this).undoLimit||u,e.addShortcut("ctrl+z",r.undo),e.addShortcut("ctrl+shift+z",r.redo),e.addShortcut("ctrl+y",r.redo)},r.undo=function(){var t=n.pop(),r=e.val(null,!1);return t&&!a.length&&r===t.value&&(t=n.pop()),t&&(a.length||a.push({caret:e.sourceEditorCaret(),sourceMode:e.sourceMode(),value:r}),a.push(t),s(t)),!1},r.redo=function(){var e=a.pop();return n.length||(n.push(e),e=a.pop()),e&&(n.push(e),s(e)),!1},r.signalReady=function(){var r=e.val(null,!1);t=r,n.push({caret:this.sourceEditorCaret(),sourceMode:this.sourceMode(),value:r})},r.signalValuechangedEvent=function(r){var s=r.detail.rawValue;u>0&&n.length>u&&n.shift(),!c&&t&&t!==s&&(a.length=0,(o+=l(t,s))<20||o<50&&!/\s$/g.test(r.rawValue)||(n.push({caret:e.sourceEditorCaret(),sourceMode:e.sourceMode(),value:s}),o=0,t=s))}}}(sceditor);