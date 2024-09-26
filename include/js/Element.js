function bt(id,after) { 
var img = document.getElementById(id);
img.filters.blendTrans.stop();
img.filters.blendTrans.Apply();
img.src=after;
img.filters.blendTrans.Play();
} 