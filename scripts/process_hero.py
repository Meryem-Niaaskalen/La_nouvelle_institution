import sys
from PIL import Image, ImageFilter, ImageEnhance, ImageOps
import numpy as np
import math

input_path = r"c:\Users\pc\AppData\Roaming\Code\User\globalStorage\github.copilot-chat\copilot-cli-images\1785330978832-ns33fxo0.jpg"
output_path = r"frontend\public\images\hero-16x9.jpg"

print('Loading image:', input_path)
img = Image.open(input_path).convert('RGB')
w, h = img.size
print('Original size:', w, h)

# Crop bottom street: remove bottom 10% of image
crop_bottom = int(h * 0.10)
img = img.crop((0, 0, w, h - crop_bottom))
print('Cropped bottom:', img.size)

# Convert to numpy for simple orange detection
arr = np.array(img).astype('float32') / 255.0
r = arr[:,:,0]
g = arr[:,:,1]
b = arr[:,:,2]

# Simple orange mask: r high, g medium, b low
orange_mask = (r > 0.6) & (g > 0.25) & (g < 0.7) & (b < 0.4)
col_orange_counts = orange_mask.sum(axis=0)

if col_orange_counts.max() > 0:
    center_x = int((col_orange_counts * np.arange(col_orange_counts.size)).sum() / col_orange_counts.sum())
else:
    center_x = img.size[0] // 2
print('Detected center_x:', center_x)

# Target aspect 16:9
target_w = 1600
target_h = 900
ratio = target_w / target_h

cur_w, cur_h = img.size
cur_ratio = cur_w / cur_h

# Determine crop box to match ratio while centering on center_x
if cur_ratio > ratio:
    # too wide -> crop width
    new_w = int(cur_h * ratio)
    left = max(0, center_x - new_w//2)
    right = left + new_w
    if right > cur_w:
        right = cur_w
        left = cur_w - new_w
    box = (left, 0, right, cur_h)
else:
    # too tall -> crop height
    new_h = int(cur_w / ratio)
    top = 0
    box = (0, top, cur_w, new_h)

img = img.crop(box)
print('Cropped to aspect ratio:', img.size)

# Resize to target
img = img.resize((target_w, target_h), Image.LANCZOS)
print('Resized to:', img.size)

# Enhance brightness/contrast
enh_b = ImageEnhance.Brightness(img).enhance(1.06)
enh_c = ImageEnhance.Contrast(enh_b).enhance(1.08)
img = enh_c

# Boost orange saturation and deepen grays
arr = np.array(img).astype('float32') / 255.0
r = arr[:,:,0]
g = arr[:,:,1]
b = arr[:,:,2]

# Convert to HSV-like approximated hue for speed
maxc = np.maximum(np.maximum(r,g), b)
minc = np.minimum(np.minimum(r,g), b)
delta = maxc - minc + 1e-6

# Hue calculation (0-360)
h = np.zeros_like(maxc)
mask = (maxc == r)
h[mask] = (60 * ((g[mask]-b[mask]) / delta[mask]) + 360) % 360
mask = (maxc == g)
h[mask] = (60 * ((b[mask]-r[mask]) / delta[mask]) + 120) % 360
mask = (maxc == b)
h[mask] = (60 * ((r[mask]-g[mask]) / delta[mask]) + 240) % 360

# Saturation approximation
s = delta / (maxc + 1e-6)

# Boost orange hues 15..35 deg
orange_zone = (h >= 15) & (h <= 40) & (s > 0.15)
arr[:,:,0][orange_zone] = np.clip(arr[:,:,0][orange_zone]*1.15 + 0.02, 0, 1)
arr[:,:,1][orange_zone] = np.clip(arr[:,:,1][orange_zone]*1.05 + 0.01, 0, 1)
arr[:,:,2][orange_zone] = np.clip(arr[:,:,2][orange_zone]*0.9, 0, 1)

# Deepen grays: low saturation region and mid brightness
gray_zone = (s < 0.12) & (maxc > 0.2) & (maxc < 0.85)
arr[gray_zone] = np.clip(arr[gray_zone] * 0.88, 0, 1)

# Convert back
proc = (arr*255).astype('uint8')
img_proc = Image.fromarray(proc)

# Add warm sunlight radial overlay
overlay = Image.new('RGBA', img_proc.size, (255,255,255,0))
ox, oy = int(target_w*0.75), int(target_h*0.2)
rad = int(min(target_w, target_h)*0.6)
overlay_arr = np.zeros((target_h, target_w, 4), dtype=np.uint8)
for y in range(target_h):
    for x in range(target_w):
        dx = x-ox
        dy = y-oy
        d = math.sqrt(dx*dx+dy*dy)
        t = max(0, 1 - (d / rad))
        a = int((t**1.6) * 90)
        if a>0:
            overlay_arr[y,x] = [255,160,70,a]

overlay = Image.fromarray(overlay_arr, 'RGBA')
img_rgba = img_proc.convert('RGBA')
img_rgba = Image.alpha_composite(img_rgba, overlay)

# Background edge blur: create blurred version and composite with circular mask
blur = img_rgba.filter(ImageFilter.GaussianBlur(radius=14))
mask = Image.new('L', img_rgba.size, 0)
mx, my = target_w//2, int(target_h*0.38)
for y in range(target_h):
    for x in range(target_w):
        dx = (x-mx)/ (target_w*0.5)
        dy = (y-my)/ (target_h*0.45)
        d = math.sqrt(dx*dx + dy*dy)
        val = int(255 * (1 - np.clip((d-0.4)/0.6, 0, 1)))
        mask.putpixel((x,y), val)

final = Image.composite(img_rgba, blur, mask.convert('L'))

# Slight color grade: warm tint
r,g,b,a = final.split()
# Merge with slight orange tint
tint = Image.new('RGBA', final.size, (248,150,30,18))
final = Image.alpha_composite(final, tint)

# Save
final.convert('RGB').save(output_path, quality=92)
print('Saved processed hero to', output_path)

print('Done')
